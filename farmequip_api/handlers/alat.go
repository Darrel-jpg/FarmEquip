package handlers

import (
	"database/sql"
	"encoding/base64"
	"encoding/json"
	"farmequip_api/models"
	"io"
	"net/http"
	"sort"

	"github.com/gorilla/mux"
)

func GetAlat(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")

		// Ambil query param sort
		sortParam := r.URL.Query().Get("sort")

		rows, err := db.Query(`
            SELECT 
                a.id,
                a.nama_alat,
                a.kategori_id,
                k.nama_kategori,
                a.deskripsi,
                a.harga_per_hari,
                a.harga_per_minggu,
                a.harga_per_bulan,
                a.gambar
            FROM alat_pertanian a
            JOIN kategori k ON k.id = a.kategori_id
        `)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}
		defer rows.Close()

		var list []models.Alat

		for rows.Next() {
			var a models.Alat
			var imgBytes []byte

			err := rows.Scan(
				&a.ID,
				&a.NamaAlat,
				&a.KategoriID,
				&a.NamaKategori,
				&a.Deskripsi,
				&a.HargaHarian,
				&a.HargaMingguan,
				&a.HargaBulanan,
				&imgBytes,
			)
			if err != nil {
				w.Write([]byte(err.Error()))
				return
			}

			a.Gambar = base64.StdEncoding.EncodeToString(imgBytes)
			list = append(list, a)
		}

		// ================================
		// ✨ TRANSFORMASI DATA: SORTING FP
		// ================================
		sort.Slice(list, func(i, j int) bool {
			switch sortParam {
			case "nama_asc":
				return list[i].NamaAlat < list[j].NamaAlat
			case "nama_desc":
				return list[i].NamaAlat > list[j].NamaAlat
			case "harga_asc":
				return list[i].HargaHarian < list[j].HargaHarian
			case "harga_desc":
				return list[i].HargaHarian > list[j].HargaHarian
			case "newest":
				return list[i].ID > list[j].ID
			case "oldest":
				return list[i].ID < list[j].ID
			default:
				// default: oldest (ID ascending)
				return list[i].ID < list[j].ID
			}
		})

		// Output JSON
		json.NewEncoder(w).Encode(list)
	}
}

func GetToolById(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")
		id := mux.Vars(r)["id"]

		row := db.QueryRow("SELECT id, nama_alat, kategori_id, deskripsi, harga_per_hari, harga_per_minggu, harga_per_bulan FROM alat_pertanian WHERE id = ?", id)

		var alat struct {
			ID         int    `json:"id"`
			Nama       string `json:"nama_alat"`
			KategoriID int    `json:"kategori_id"`
			Deskripsi  string `json:"deskripsi"`
			Hari       int    `json:"harga_per_hari"`
			Minggu     int    `json:"harga_per_minggu"`
			Bulan      int    `json:"harga_per_bulan"`
		}

		err := row.Scan(&alat.ID, &alat.Nama, &alat.KategoriID, &alat.Deskripsi, &alat.Hari, &alat.Minggu, &alat.Bulan)
		if err != nil {
			http.Error(w, "Alat tidak ditemukan", http.StatusNotFound)
			return
		}

		json.NewEncoder(w).Encode(alat)
	}
}

func CreateAlat(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		r.ParseMultipartForm(10 << 20)

		nama := r.FormValue("nama_alat")
		kategori := r.FormValue("kategori_id")
		deskripsi := r.FormValue("deskripsi")
		hari := r.FormValue("harga_per_hari")
		minggu := r.FormValue("harga_per_minggu")
		bulan := r.FormValue("harga_per_bulan")

		// Gambar
		file, _, err := r.FormFile("gambar")
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}
		defer file.Close()

		gambar, _ := io.ReadAll(file)

		_, err = db.Exec(`
			INSERT INTO alat_pertanian 
			(nama_alat, kategori_id, deskripsi, harga_per_hari, harga_per_minggu, harga_per_bulan, gambar)
			VALUES (?, ?, ?, ?, ?, ?, ?)
		`, nama, kategori, deskripsi, hari, minggu, bulan, gambar)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Alat berhasil ditambahkan"))
	}
}

func GetAlatBySlug(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")
		slug := mux.Vars(r)["slug"]
		if slug == "" {
			w.Write([]byte("Slug kategori wajib diisi"))
			return
		}

		rows, err := db.Query(`
            SELECT 
                a.id,
                a.nama_alat,
                a.kategori_id,
                k.nama_kategori,
                a.deskripsi,
                a.harga_per_hari,
                a.harga_per_minggu,
                a.harga_per_bulan,
                a.gambar
            FROM alat_pertanian a
            JOIN kategori k ON a.kategori_id = k.id
            WHERE k.slug = ?
        `, slug)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}
		defer rows.Close()

		var list []models.Alat

		for rows.Next() {
			var a models.Alat
			var imgBytes []byte

			err := rows.Scan(
				&a.ID,
				&a.NamaAlat,
				&a.KategoriID,
				&a.NamaKategori,
				&a.Deskripsi,
				&a.HargaHarian,
				&a.HargaMingguan,
				&a.HargaBulanan,
				&imgBytes,
			)
			if err != nil {
				w.Write([]byte(err.Error()))
				return
			}

			a.Gambar = base64.StdEncoding.EncodeToString(imgBytes)

			list = append(list, a)
		}

		if len(list) == 0 {
			w.Write([]byte("Tidak ada alat dalam kategori ini"))
			return
		}

		json.NewEncoder(w).Encode(list)
	}
}

func UpdateAlat(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID alat wajib diisi"))
			return
		}

		r.ParseMultipartForm(10 << 20)

		nama := r.FormValue("nama_alat")
		kategori := r.FormValue("kategori_id")
		deskripsi := r.FormValue("deskripsi")
		hari := r.FormValue("harga_per_hari")
		minggu := r.FormValue("harga_per_minggu")
		bulan := r.FormValue("harga_per_bulan")

		// cek apakah ada file gambar baru
		var gambar []byte
		file, _, err := r.FormFile("gambar")

		if err == nil {
			defer file.Close()
			gambar, _ = io.ReadAll(file)
		} else {
			// ambil gambar lama kalau tidak upload baru
			err = db.QueryRow(`SELECT gambar FROM alat_pertanian WHERE id = ?`, id).Scan(&gambar)
			if err != nil {
				w.Write([]byte("Gagal mengambil gambar lama: " + err.Error()))
				return
			}
		}

		_, err = db.Exec(`
            UPDATE alat_pertanian
            SET nama_alat = ?, kategori_id = ?, deskripsi = ?, 
                harga_per_hari = ?, harga_per_minggu = ?, harga_per_bulan = ?, gambar = ?
            WHERE id = ?
        `, nama, kategori, deskripsi, hari, minggu, bulan, gambar, id)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Alat berhasil diperbarui"))
	}
}

func DeleteAlat(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID alat wajib diisi"))
			return
		}

		_, err := db.Exec(`DELETE FROM alat_pertanian WHERE id = ?`, id)
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Alat berhasil dihapus"))
	}
}
