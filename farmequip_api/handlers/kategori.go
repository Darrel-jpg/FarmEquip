package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"farmequip_api/utils"
	"net/http"
)

//Pure function mapping
func MapRowToKategori(rows *sql.Rows) (models.Kategori, error) {
	var k models.Kategori
	err := rows.Scan(
		&k.ID, &k.NamaKategori, &k.Deskripsi, &k.Slug,
	)
	return k, err
}

// Transform rows
func MapKategoriRows(rows *sql.Rows) ([]models.Kategori, error) {
	var list []models.Kategori
	for rows.Next() {
		k, err := MapRowToKategori(rows)
		if err != nil {
			return nil, err
		}
		list = append(list, k)
	}
	return list, nil
}


func GetKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		respondJSON := jsonResponder(w)

		rows, err := db.Query(`
			SELECT id, nama_kategori, deskripsi, slug 
			FROM kategori
		`)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}
		defer rows.Close()

		list, err := MapKategoriRows(rows)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		respondJSON(list)
	}
}


func CreateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		var k models.Kategori
		if err := json.NewDecoder(r.Body).Decode(&k); err != nil {
			http.Error(w, "Gagal membaca request body", 400)
			return
		}

		if k.NamaKategori == "" {
			http.Error(w, "Nama kategori wajib diisi", 400)
			return
		}

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
			INSERT INTO kategori (nama_kategori, deskripsi, slug)
			VALUES (?, ?, ?)
		`, k.NamaKategori, k.Deskripsi, slug)

		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Kategori berhasil ditambahkan"))
	}
}


func UpdateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := r.URL.Query().Get("id")
		if id == "" {
			http.Error(w, "ID kategori wajib diisi", 400)
			return
		}

		var k models.Kategori
		if err := json.NewDecoder(r.Body).Decode(&k); err != nil {
			http.Error(w, "Gagal membaca request body", 400)
			return
		}

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
			UPDATE kategori 
			SET nama_kategori = ?, deskripsi = ?, slug = ?
			WHERE id = ?
		`, k.NamaKategori, k.Deskripsi, slug, id)

		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Kategori berhasil diupdate"))
	}
}

func DeleteKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := r.URL.Query().Get("id")
        if id == "" {
            http.Error(w, "ID kategori wajib diisi", 400)
            return
        }

		_, err := db.Exec(`DELETE FROM kategori WHERE id = ?`, id)
		if err != nil {
			http.Error(w, err.Error(), 500)
			return
		}

		w.Write([]byte("Kategori berhasil dihapus"))
	}
}