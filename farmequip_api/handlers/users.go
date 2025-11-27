<<<<<<< HEAD
package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"net/http"
)

func Login(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		var req models.User
		json.NewDecoder(r.Body).Decode(&req)

		if (req.Email == "" && req.Username == "") || req.Password == "" {
			w.Write([]byte("Email/Username dan Password wajib diisi"))
			return
		}

		var user models.User
		err := db.QueryRow(
			"SELECT id, nama, email, username FROM users WHERE (email = ? OR username = ?) AND password = ?",
			req.Email, req.Username, req.Password,
		).Scan(&user.ID, &user.Nama, &user.Email, &user.Username)

		if err != nil {
			if err == sql.ErrNoRows {
				w.Write([]byte("Email/Username atau password salah"))
				return
			}
			w.Write([]byte(err.Error()))
			return
		}

		json.NewEncoder(w).Encode(map[string]interface{}{
			"status": "success",
			"user":   user,
		})
	}
}

func UpdateUser(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("Parameter id diperlukan"))
			return
		}

		var u models.User
		json.NewDecoder(r.Body).Decode(&u)

		_, err := db.Exec(`
            UPDATE users 
            SET nama = ?, email = ?, username = ?, password = ? 
            WHERE id = ?`,
			u.Nama, u.Email, u.Username, u.Password, id,
		)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("User berhasil diupdate"))
	}
}

// func GetUsers(db *sql.DB) http.HandlerFunc {
// 	return func(w http.ResponseWriter, r *http.Request) {
// 		rows, err := db.Query("SELECT id, nama, email FROM users")
// 		if err != nil {
// 			w.Write([]byte(err.Error()))
// 			return
// 		}
// 		defer rows.Close()

// 		var users []models.User

// 		for rows.Next() {
// 			var u models.User
// 			rows.Scan(&u.ID, &u.Nama, &u.Email)
// 			users = append(users, u)
// 		}

// 		json.NewEncoder(w).Encode(users)
// 	}
// }

// func CreateUser(db *sql.DB) http.HandlerFunc {
// 	return func(w http.ResponseWriter, r *http.Request) {
// 		var u models.User
// 		json.NewDecoder(r.Body).Decode(&u)

// 		_, err := db.Exec("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)",
// 			u.Nama, u.Email, "password123")
// 		if err != nil {
// 			w.Write([]byte(err.Error()))
// 			return
// 		}

// 		w.Write([]byte("User berhasil dibuat"))
// 	}
// }
=======
package handlers

import (
	"database/sql"
	"encoding/json"
	"farmequip_api/models"
	"net/http"
)

func Login(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		var req models.User
		json.NewDecoder(r.Body).Decode(&req)

		if (req.Email == "" && req.Username == "") || req.Password == "" {
			w.Write([]byte("Email/Username dan Password wajib diisi"))
			return
		}

		var user models.User
		err := db.QueryRow(
			"SELECT id, nama, email, username FROM users WHERE (email = ? OR username = ?) AND password = ?",
			req.Email, req.Username, req.Password,
		).Scan(&user.ID, &user.Nama, &user.Email, &user.Username)

		if err != nil {
			if err == sql.ErrNoRows {
				w.Write([]byte("Email/Username atau password salah"))
				return
			}
			w.Write([]byte(err.Error()))
			return
		}

		json.NewEncoder(w).Encode(map[string]interface{}{
			"status": "success",
			"user":   user,
		})
	}
}

func UpdateUser(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {

		id := r.URL.Query().Get("id")
		if id == "" {
			w.Write([]byte("Parameter id diperlukan"))
			return
		}

		var u models.User
		json.NewDecoder(r.Body).Decode(&u)

		_, err := db.Exec(`
            UPDATE users 
            SET nama = ?, email = ?, username = ?, password = ? 
            WHERE id = ?`,
			u.Nama, u.Email, u.Username, u.Password, id,
		)

		if err != nil {
			w.Write([]byte(err.Error()))
			return
		}

		w.Write([]byte("User berhasil diupdate"))
	}
}

// func GetUsers(db *sql.DB) http.HandlerFunc {
// 	return func(w http.ResponseWriter, r *http.Request) {
// 		rows, err := db.Query("SELECT id, nama, email FROM users")
// 		if err != nil {
// 			w.Write([]byte(err.Error()))
// 			return
// 		}
// 		defer rows.Close()

// 		var users []models.User

// 		for rows.Next() {
// 			var u models.User
// 			rows.Scan(&u.ID, &u.Nama, &u.Email)
// 			users = append(users, u)
// 		}

// 		json.NewEncoder(w).Encode(users)
// 	}
// }

// func CreateUser(db *sql.DB) http.HandlerFunc {
// 	return func(w http.ResponseWriter, r *http.Request) {
// 		var u models.User
// 		json.NewDecoder(r.Body).Decode(&u)

// 		_, err := db.Exec("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)",
// 			u.Nama, u.Email, "password123")
// 		if err != nil {
// 			w.Write([]byte(err.Error()))
// 			return
// 		}

// 		w.Write([]byte("User berhasil dibuat"))
// 	}
// }
>>>>>>> aad9e9c16073a1cd1a352ff8da6010409bc02900
