<<<<<<< HEAD
package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"farmequip_api/utils"
	"net/http"
)

func GetKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")
		rows, err := db.Query(`
            SELECT id, nama_kategori, deskripsi, slug 
            FROM kategori
        `)
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}
		defer rows.Close()

		var list []models.Kategori
		for rows.Next() {
			var k models.Kategori
			rows.Scan(&k.ID, &k.NamaKategori, &k.Deskripsi, &k.Slug)
			list = append(list, k)
		}

		json.NewEncoder(w).Encode(list)
	}
}

func CreateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		var k models.Kategori
		json.NewDecoder(r.Body).Decode(&k)

		if k.NamaKategori == "" {
			w.Write([]byte("Nama kategori wajib diisi"))
			return
		}

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
            INSERT INTO kategori (nama_kategori, deskripsi, slug)
            VALUES (?, ?, ?)
        `, k.NamaKategori, k.Deskripsi, slug)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil ditambahkan"))
	}
}

func UpdateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID kategori wajib diisi"))
			return
		}

		var k models.Kategori
		json.NewDecoder(r.Body).Decode(&k)

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
            UPDATE kategori 
            SET nama_kategori = ?, deskripsi = ?, slug = ?
            WHERE id = ?
        `, k.NamaKategori, k.Deskripsi, slug, id)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil diupdate"))
	}
}

func DeleteKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID kategori wajib diisi"))
			return
		}

		// Hapus kategori berdasarkan id
		_, err := db.Exec(`DELETE FROM kategori WHERE id = ?`, id)
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil dihapus"))
	}
}
=======
package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"farmequip_api/utils"
	"net/http"
)

func GetKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")
		rows, err := db.Query(`
            SELECT id, nama_kategori, deskripsi, slug 
            FROM kategori
        `)
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}
		defer rows.Close()

		var list []models.Kategori
		for rows.Next() {
			var k models.Kategori
			rows.Scan(&k.ID, &k.NamaKategori, &k.Deskripsi, &k.Slug)
			list = append(list, k)
		}

		json.NewEncoder(w).Encode(list)
	}
}

func CreateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		var k models.Kategori
		json.NewDecoder(r.Body).Decode(&k)

		if k.NamaKategori == "" {
			w.Write([]byte("Nama kategori wajib diisi"))
			return
		}

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
            INSERT INTO kategori (nama_kategori, deskripsi, slug)
            VALUES (?, ?, ?)
        `, k.NamaKategori, k.Deskripsi, slug)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil ditambahkan"))
	}
}

func UpdateKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID kategori wajib diisi"))
			return
		}

		var k models.Kategori
		json.NewDecoder(r.Body).Decode(&k)

		slug := utils.GenerateSlug(k.NamaKategori)

		_, err := db.Exec(`
            UPDATE kategori 
            SET nama_kategori = ?, deskripsi = ?, slug = ?
            WHERE id = ?
        `, k.NamaKategori, k.Deskripsi, slug, id)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil diupdate"))
	}
}

func DeleteKategori(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("ID kategori wajib diisi"))
			return
		}

		// Hapus kategori berdasarkan id
		_, err := db.Exec(`DELETE FROM kategori WHERE id = ?`, id)
		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("Kategori berhasil dihapus"))
	}
}
>>>>>>> aad9e9c16073a1cd1a352ff8da6010409bc02900
