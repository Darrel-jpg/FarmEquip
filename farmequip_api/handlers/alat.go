package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"fmt"
	"net/http"
	"path/filepath"
	"sort"
	"strings"

	"github.com/cloudinary/cloudinary-go/v2"
	"github.com/cloudinary/cloudinary-go/v2/api/uploader"
	"github.com/gorilla/mux"
)

//Pure func
func mapRowToAlat(rows *sql.Rows) (models.Alat, error) {
	var a models.Alat
	err := rows.Scan(
		&a.ID, &a.NamaAlat, &a.KategoriID, &a.NamaKategori,
		&a.Deskripsi, &a.HargaHarian, &a.HargaMingguan,
		&a.HargaBulanan, &a.Gambar, &a.Spesifikasi,
	)
	return a, err
}

//HOF
func jsonResponder(w http.ResponseWriter) func(data interface{}) {
	w.Header().Set("Content-Type", "application/json")
	return func(data interface{}) {
		json.NewEncoder(w).Encode(data)
	}
}

//Pure func: transformasi rows → slice
func mapRows(rows *sql.Rows) ([]models.Alat, error) {
	var list []models.Alat
	for rows.Next() {
		a, err := mapRowToAlat(rows)
		if err != nil {
			return nil, err
		}
		list = append(list, a)
	}
	return list, nil
}


func GetAlat(db *sql.DB) http.HandlerFunc {

    // HOF
    createSorter := func(sortParam string, alatList []models.Alat) func(i, j int) bool {
        switch sortParam {
        case "nama_asc":
            return func(i, j int) bool { return alatList[i].NamaAlat < alatList[j].NamaAlat }
        case "nama_desc":
            return func(i, j int) bool { return alatList[i].NamaAlat > alatList[j].NamaAlat }
        case "harga_asc":
            return func(i, j int) bool { return alatList[i].HargaHarian < alatList[j].HargaHarian }
        case "harga_desc":
            return func(i, j int) bool { return alatList[i].HargaHarian > alatList[j].HargaHarian }
        case "newest":
            return func(i, j int) bool { return alatList[i].ID > alatList[j].ID }
        case "oldest":
            return func(i, j int) bool { return alatList[i].ID < alatList[j].ID }
        }
        return func(i, j int) bool { return alatList[i].ID < alatList[j].ID }
    }

    return func(w http.ResponseWriter, r *http.Request) {
        
        respondJSON := jsonResponder(w)

        sortParam := r.URL.Query().Get("sort")

        rows, err := db.Query(`
            SELECT 
                a.id, a.nama_alat, a.kategori_id, k.nama_kategori,
                a.deskripsi, a.harga_per_hari, a.harga_per_minggu,
                a.harga_per_bulan, a.gambar, a.spesifikasi
            FROM alat_pertanian a
            JOIN kategori k ON k.id = a.kategori_id
        `)
        if err != nil {
            http.Error(w, err.Error(), 500)
            return
        }
        defer rows.Close()

        //transform
        alatList, err := mapRows(rows)
        if err != nil {
            http.Error(w, err.Error(), 500)
            return
        }

        //sort
        sort.Slice(alatList, createSorter(sortParam, alatList))
        respondJSON(alatList)
    }
}

func GetToolById(db *sql.DB) http.HandlerFunc {

	return func(w http.ResponseWriter, r *http.Request) {
		respond := jsonResponder(w)
		id := mux.Vars(r)["id"]

        //Pure func
		queryByID := func(id string) (*sql.Rows, error) {
			return db.Query(`
				SELECT 
					a.id, a.nama_alat, a.kategori_id, k.nama_kategori,
					a.deskripsi, a.harga_per_hari, a.harga_per_minggu,
					a.harga_per_bulan, a.gambar, a.spesifikasi
				FROM alat_pertanian a
				JOIN kategori k ON a.kategori_id = k.id
				WHERE a.id = ?
			`, id)
		}

		rows, err := queryByID(id)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}
		defer rows.Close()

		list, err := mapRows(rows)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		respond(list)
	}
}


func CreateAlat(db *sql.DB, cld *cloudinary.Cloudinary) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		r.ParseMultipartForm(10 << 20)

		nama := r.FormValue("nama_alat")
		kategori := r.FormValue("kategori_id")
		deskripsi := r.FormValue("deskripsi")
		hari := r.FormValue("harga_per_hari")
		minggu := r.FormValue("harga_per_minggu")
		bulan := r.FormValue("harga_per_bulan")
		spesifikasi := r.FormValue("spesifikasi")

		file, header, err := r.FormFile("gambar")
		if err != nil {
			http.Error(w, "Gambar wajib diupload", 400)
			return
		}
		defer file.Close()

		upload, err := cld.Upload.Upload(r.Context(), file, uploader.UploadParams{
			PublicID: header.Filename,
		})
		if err != nil {
			http.Error(w, "Upload Cloudinary gagal: "+err.Error(), 500)
			return
		}

		_, err = db.Exec(`
			INSERT INTO alat_pertanian 
			(nama_alat, kategori_id, deskripsi, harga_per_hari, harga_per_minggu,
			 harga_per_bulan, gambar, spesifikasi)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)
		`, nama, kategori, deskripsi, hari, minggu, bulan, upload.SecureURL, spesifikasi)

		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Alat berhasil ditambahkan"))
	}
}

func GetAlatBySlug(db *sql.DB) http.HandlerFunc {

	queryBySlug := func(slug string) func() (*sql.Rows, error) {
		return func() (*sql.Rows, error) {
			return db.Query(`
				SELECT 
					a.id, a.nama_alat, a.kategori_id, k.nama_kategori,
					a.deskripsi, a.harga_per_hari, a.harga_per_minggu,
					a.harga_per_bulan, a.gambar, a.spesifikasi
				FROM alat_pertanian a
				JOIN kategori k ON a.kategori_id = k.id
				WHERE k.slug = ?
			`, slug)
		}
	}

	return func(w http.ResponseWriter, r *http.Request) {
		respond := jsonResponder(w)
		slug := mux.Vars(r)["slug"]

		rows, err := queryBySlug(slug)()
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}
		defer rows.Close()

		list, err := mapRows(rows)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		respond(list)
	}
}


func UpdateAlat(db *sql.DB, cld *cloudinary.Cloudinary) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := r.URL.Query().Get("id")
		if id == "" {
			http.Error(w, "ID alat wajib diisi", 400)
			return
		}

		r.ParseMultipartForm(10 << 20)

		nama := r.FormValue("nama_alat")
		kategori := r.FormValue("kategori_id")
		deskripsi := r.FormValue("deskripsi")
		hari := r.FormValue("harga_per_hari")
		minggu := r.FormValue("harga_per_minggu")
		bulan := r.FormValue("harga_per_bulan")
		spesifikasi := r.FormValue("spesifikasi")

		var oldURL string
		db.QueryRow(`SELECT gambar FROM alat_pertanian WHERE id = ?`, id).Scan(&oldURL)

		file, header, err := r.FormFile("gambar")

		newURL := oldURL

		if err == nil {
			defer file.Close()

			upload, err := cld.Upload.Upload(r.Context(), file, uploader.UploadParams{
				PublicID: header.Filename,
			})
			if err != nil {
				http.Error(w, "Gagal upload cloudinary: "+err.Error(), 500)
				return
			}

			newURL = upload.SecureURL
		}

		_, err = db.Exec(`
			UPDATE alat_pertanian
			SET nama_alat=?, kategori_id=?, deskripsi=?, harga_per_hari=?,
				harga_per_minggu=?, harga_per_bulan=?, gambar=?, spesifikasi=?
			WHERE id=?
		`, nama, kategori, deskripsi, hari, minggu, bulan, newURL, spesifikasi, id)

		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Alat berhasil diperbarui"))
	}
}

func DeleteAlat(db *sql.DB, cld *cloudinary.Cloudinary) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			http.Error(w, "ID wajib diisi", 400)
			return
		}

		var imageURL string
		db.QueryRow(`SELECT gambar FROM alat_pertanian WHERE id = ?`, id).Scan(&imageURL)

		if imageURL != "" {
			parts := strings.Split(imageURL, "/")
			fileName := parts[len(parts)-1]
			publicID := strings.TrimSuffix(fileName, filepath.Ext(fileName))

			_, err := cld.Upload.Destroy(r.Context(), uploader.DestroyParams{
				PublicID: publicID,
			})

			if err != nil {
				fmt.Println("Gagal delete Cloudinary:", err)
			}
		}

		_, err := db.Exec(`DELETE FROM alat_pertanian WHERE id = ?`, id)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Alat berhasil dihapus"))
	}
}
