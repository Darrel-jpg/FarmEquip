package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os"
	"strconv"
	"strings"
	"time"

	_ "github.com/go-sql-driver/mysql"
)

// Model struct sesuai tabel MySQL
type Tool struct {
	ID          uint64     `json:"id"`
	Name        string     `json:"name"`
	Category    string     `json:"category"`
	PricePerDay int        `json:"price_per_day"`
	Status      string     `json:"status"`
	Description *string    `json:"description,omitempty"`
	ImageURL    *string    `json:"image_url,omitempty"`
	CreatedAt   *time.Time `json:"created_at,omitempty"`
	UpdatedAt   *time.Time `json:"updated_at,omitempty"`
}

var db *sql.DB

func main() {
	// Koneksi Database
	var err error
	db, err = sql.Open(
		"mysql",
		"root:@tcp(127.0.0.1:3306)/alatdb?parseTime=true",
	)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Routing sederhana
	http.HandleFunc("/tools", toolsHandler)
	http.HandleFunc("/tools/", toolDetailHandler)

	port := os.Getenv("PORT")
	if port == "" {
		port = "8080"
	}

	fmt.Println("API jalan di port:", port)
	log.Fatal(http.ListenAndServe(":"+port, nil))
}

// ---------------------- Handlers ----------------------

// GET /tools
// POST /tools
func toolsHandler(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getAllTools(w, r)
	case http.MethodPost:
		createTool(w, r)
	default:
		http.Error(w, "Method tidak diperbolehkan", http.StatusMethodNotAllowed)
	}
}

// GET /tools/{id}
// PUT /tools/{id}
// DELETE /tools/{id}
func toolDetailHandler(w http.ResponseWriter, r *http.Request) {
	idStr := strings.TrimPrefix(r.URL.Path, "/tools/")
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "ID tidak valid", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getToolByID(w, uint64(id))
	case http.MethodPut:
		updateTool(w, r, uint64(id))
	case http.MethodDelete:
		deleteTool(w, uint64(id))
	default:
		http.Error(w, "Method tidak diperbolehkan", http.StatusMethodNotAllowed)
	}
}

// ---------------------- CRUD Functions ----------------------

func getAllTools(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("SELECT * FROM tools")
	if err != nil {
		http.Error(w, "Query gagal", 500)
		return
	}
	defer rows.Close()

	var tools []Tool

	for rows.Next() {
		var t Tool
		var desc, img sql.NullString
		var cAt, uAt sql.NullTime

		rows.Scan(&t.ID, &t.Name, &t.Category, &t.PricePerDay, &t.Status,
			&desc, &img, &cAt, &uAt)

		if desc.Valid {
			t.Description = &desc.String
		}
		if img.Valid {
			t.ImageURL = &img.String
		}
		if cAt.Valid {
			t.CreatedAt = &cAt.Time
		}
		if uAt.Valid {
			t.UpdatedAt = &uAt.Time
		}

		tools = append(tools, t)
	}

	json.NewEncoder(w).Encode(tools)
}

func getToolByID(w http.ResponseWriter, id uint64) {
	row := db.QueryRow("SELECT * FROM tools WHERE id = ?", id)

	var t Tool
	var desc, img sql.NullString
	var cAt, uAt sql.NullTime

	err := row.Scan(&t.ID, &t.Name, &t.Category, &t.PricePerDay, &t.Status,
		&desc, &img, &cAt, &uAt)

	if err == sql.ErrNoRows {
		http.Error(w, "Not found", 404)
		return
	}

	if desc.Valid {
		t.Description = &desc.String
	}
	if img.Valid {
		t.ImageURL = &img.String
	}
	if cAt.Valid {
		t.CreatedAt = &cAt.Time
	}
	if uAt.Valid {
		t.UpdatedAt = &uAt.Time
	}

	json.NewEncoder(w).Encode(t)
}

func createTool(w http.ResponseWriter, r *http.Request) {
	var t Tool
	json.NewDecoder(r.Body).Decode(&t)

	res, err := db.Exec(
		"INSERT INTO tools (name,category,price_per_day,status,description,image_url,created_at,updated_at) VALUES (?,?,?,?,?,?,NOW(),NOW())",
		t.Name, t.Category, t.PricePerDay, t.Status,
		t.Description, t.ImageURL,
	)

	if err != nil {
		http.Error(w, "Gagal insert", 500)
		return
	}

	id, _ := res.LastInsertId()
	t.ID = uint64(id)

	json.NewEncoder(w).Encode(t)
}

func updateTool(w http.ResponseWriter, r *http.Request, id uint64) {
	var t Tool
	json.NewDecoder(r.Body).Decode(&t)

	_, err := db.Exec(
		"UPDATE tools SET name=?, category=?, price_per_day=?, status=?, description=?, image_url=?, updated_at=NOW() WHERE id=?",
		t.Name, t.Category, t.PricePerDay, t.Status,
		t.Description, t.ImageURL, id,
	)

	if err != nil {
		http.Error(w, "Gagal update", 500)
		return
	}

	t.ID = id
	json.NewEncoder(w).Encode(t)
}

func deleteTool(w http.ResponseWriter, id uint64) {
	_, err := db.Exec("DELETE FROM tools WHERE id = ?", id)
	if err != nil {
		http.Error(w, "Gagal delete", 500)
		return
	}

	w.Write([]byte(`{"status":"deleted"}`))
}
