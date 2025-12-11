package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"net/http"
)

func MapRowToUser(row *sql.Row) (models.User, error) {
	var u models.User
	err := row.Scan(&u.ID, &u.Nama, &u.Email, &u.Username)
	return u, err
}

func Login(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		respondJSON := jsonResponder(w)

		var req models.User
		if err := json.NewDecoder(r.Body).Decode(&req); err != nil {
			http.Error(w, "Gagal membaca request body", 400)
			return
		}

		// Pure validation function (optional: bisa dipisah ke utils)
		if (req.Email == "" && req.Username == "") || req.Password == "" {
			http.Error(w, "Email/Username dan Password wajib diisi", 400)
			return
		}

		row := db.QueryRow(`
			SELECT id, nama, email, username
			FROM users
			WHERE (email = ? OR username = ?) AND password = ?
		`, req.Email, req.Username, req.Password)

		user, err := MapRowToUser(row)

		if err != nil {
			if err == sql.ErrNoRows {
				http.Error(w, "Email/Username atau password salah", 400)
				return
			}
			http.Error(w, err.Error(), 500)
			return
		}

		respondJSON(map[string]interface{}{
			"status": "success",
			"user":   user,
		})
	}
}
