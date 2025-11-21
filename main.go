package main

import (
	"database/sql"
	"encoding/base64"
	"encoding/json"
	"fmt"
	"io"
	"log"
	"net/http"
	"strconv"

	_ "github.com/go-sql-driver/mysql"
)

type Alat struct {
	ID       int    `json:"id"`
	Nama     string `json:"nama"`
	Harga    int    `json:"harga"`
	Kategori string `json:"kategori"`
	FotoURL  string `json:"fotourl"` // base64 image
}

var db *sql.DB

func main() {
	var err error
	db, err = sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/alatdb")
	if err != nil {
		log.Fatal(err)
	}

	http.HandleFunc("/alatpertanian", handler)

	fmt.Println("API berjalan di http://localhost:8080")
	http.ListenAndServe(":8080", nil)
}

func handler(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")

	switch r.Method {
	case http.MethodGet:
		getAll(w, r)

	case http.MethodPost:
		create(w, r)

	case http.MethodPut:
		update(w, r)

	case http.MethodDelete:
		deleteItem(w, r)

	default:
		http.Error(w, "Method tidak diizinkan", 405)
	}
}

func getAll(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("SELECT id, nama, harga, kategori, fotourl FROM alatpertanian")
	if err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	var result []Alat
	for rows.Next() {
		var a Alat
		rows.Scan(&a.ID, &a.Nama, &a.Harga, &a.Kategori, &a.FotoURL)
		result = append(result, a)
	}

	json.NewEncoder(w).Encode(result)
}

func create(w http.ResponseWriter, r *http.Request) {
	r.ParseMultipartForm(10 << 20) // max 10MB

	file, _, err := r.FormFile("foto")
	if err != nil {
		http.Error(w, "Foto tidak ditemukan", 400)
		return
	}
	defer file.Close()

	fileBytes, _ := io.ReadAll(file)
	base64Image := base64.StdEncoding.EncodeToString(fileBytes)

	nama := r.FormValue("nama")
	harga, _ := strconv.Atoi(r.FormValue("harga"))
	kategori := r.FormValue("kategori")

	res, err := db.Exec("INSERT INTO alatpertanian (nama, harga, kategori, fotourl) VALUES (?, ?, ?, ?)",
		nama, harga, kategori, base64Image)

	if err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	id, _ := res.LastInsertId()
	json.NewEncoder(w).Encode(map[string]any{
		"id":       id,
		"nama":     nama,
		"harga":    harga,
		"kategori": kategori,
		"fotourl":  base64Image,
	})
}

func update(w http.ResponseWriter, r *http.Request) {
	id, _ := strconv.Atoi(r.URL.Query().Get("id"))
	r.ParseMultipartForm(10 << 20)

	nama := r.FormValue("nama")
	harga, _ := strconv.Atoi(r.FormValue("harga"))
	kategori := r.FormValue("kategori")

	var base64Image string

	file, _, err := r.FormFile("foto")
	if err == nil {
		fileBytes, _ := io.ReadAll(file)
		base64Image = base64.StdEncoding.EncodeToString(fileBytes)
	} else {
		db.QueryRow("SELECT fotourl FROM alatpertanian WHERE id=?", id).Scan(&base64Image)
	}

	_, err = db.Exec("UPDATE alatpertanian SET nama=?, harga=?, kategori=?, fotourl=? WHERE id=?",
		nama, harga, kategori, base64Image, id)

	if err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	json.NewEncoder(w).Encode("updated")
}

func deleteItem(w http.ResponseWriter, r *http.Request) {
	id, _ := strconv.Atoi(r.URL.Query().Get("id"))
	db.Exec("DELETE FROM alatpertanian WHERE id=?", id)
	json.NewEncoder(w).Encode("deleted")
}
