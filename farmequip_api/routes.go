package main

import (
	"database/sql"
	"net/http"
	"github.com/gorilla/mux"
	"farmequip_api/handlers"
)

func enableCORS(next http.HandlerFunc) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Access-Control-Allow-Origin", "*")
		w.Header().Set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
		w.Header().Set("Access-Control-Allow-Headers", "Content-Type, Authorization")

		if r.Method == "OPTIONS" {
			w.WriteHeader(http.StatusOK)
			return
		}
		next(w, r)
	}
}

func SetupRoutes(db *sql.DB) {
	r := mux.NewRouter()

	// Login
	r.HandleFunc("/login", enableCORS(handlers.Login(db))).Methods("POST")

	// Users
	r.HandleFunc("/users", enableCORS(handlers.UpdateUser(db))).Methods("PUT")

	// Kategori
	r.HandleFunc("/kategori", enableCORS(handlers.GetKategori(db))).Methods("GET")
	r.HandleFunc("/kategori", enableCORS(handlers.CreateKategori(db))).Methods("POST")
	r.HandleFunc("/kategori", enableCORS(handlers.UpdateKategori(db))).Methods("PUT")
	r.HandleFunc("/kategori", enableCORS(handlers.DeleteKategori(db))).Methods("DELETE")

	// Alat
	r.HandleFunc("/alat", enableCORS(handlers.GetAlat(db))).Methods("GET")
	r.HandleFunc("/alat", enableCORS(handlers.CreateAlat(db))).Methods("POST")
	r.HandleFunc("/alat", enableCORS(handlers.UpdateAlat(db))).Methods("PUT")
	r.HandleFunc("/alat", enableCORS(handlers.DeleteAlat(db))).Methods("DELETE")

	// Get alat by slug kategori
	r.HandleFunc("/alat/{id}", enableCORS(handlers.GetToolById(db))).Methods("GET")
	r.HandleFunc("/alat/{slug}", enableCORS(handlers.GetAlatBySlug(db))).Methods("GET")


	// GET alat by ID

	http.Handle("/", r)
}
