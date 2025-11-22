package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"strconv"
	"sync"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
)

// Tool merepresentasikan struktur data alat (Immutable)
type Tool struct {
	ID          int64   `json:"id"`
	Name        string  `json:"name"`
	Category    string  `json:"category"`
	PricePerDay int     `json:"price_per_day"`
	Status      string  `json:"status"`
	Description *string `json:"description,omitempty"`
	ImageURL    *string `json:"image_url,omitempty"`
}

// Repository interface untuk abstraksi akses data (Higher Order Function)
type Repository interface {
	GetAll() ([]Tool, error)
	GetByID(id int64) (*Tool, error)
	Create(tool Tool) (*Tool, error)
	Update(id int64, tool Tool) (*Tool, error)
	Delete(id int64) error
}

// ToolRepository implementasi konkret dari Repository
type ToolRepository struct {
	db *sql.DB
}

// NewToolRepository factory function (First Class Function)
func NewToolRepository(db *sql.DB) Repository {
	return &ToolRepository{db: db}
}

// Error handling dengan custom type (Error Handling)
type AppError struct {
	Code    int    `json:"code"`
	Message string `json:"message"`
}

func (e AppError) Error() string {
	return e.Message
}

// Transformasi data dengan Map, Filter, Reduce
type ToolTransformer func(Tool) Tool

// Pure function untuk transformasi tool (Fungsi Murni)
func TransformToolName(prefix string) ToolTransformer {
	return func(t Tool) Tool {
		return Tool{
			ID:          t.ID,
			Name:        prefix + " " + t.Name,
			Category:    t.Category,
			PricePerDay: t.PricePerDay,
			Status:      t.Status,
			Description: t.Description,
			ImageURL:    t.ImageURL,
		}
	}
}

// Map function untuk tools (Transformasi Data - Map)
func MapTools(tools []Tool, transformer ToolTransformer) []Tool {
	result := make([]Tool, len(tools))
	for i, tool := range tools {
		result[i] = transformer(tool)
	}
	return result
}

// Filter function untuk tools (Transformasi Data - Filter)
func FilterTools(tools []Tool, predicate func(Tool) bool) []Tool {
	var result []Tool
	for _, tool := range tools {
		if predicate(tool) {
			result = append(result, tool)
		}
	}
	return result
}

// Reduce function untuk tools (Transformasi Data - Reduce)
func ReduceTools(tools []Tool, reducer func(int, Tool) int, initial int) int {
	result := initial
	for _, tool := range tools {
		result = reducer(result, tool)
	}
	return result
}

// Implementasi Repository methods dengan error handling
func (r *ToolRepository) GetAll() ([]Tool, error) {
	rows, err := r.db.Query("SELECT id, name, category, price_per_day, status, description, image_url FROM tools")
	if err != nil {
		return nil, AppError{Code: 500, Message: "Failed to fetch tools"}
	}
	defer rows.Close()

	var tools []Tool
	for rows.Next() {
		var tool Tool
		var desc, imgURL sql.NullString

		err := rows.Scan(&tool.ID, &tool.Name, &tool.Category, &tool.PricePerDay,
			&tool.Status, &desc, &imgURL)
		if err != nil {
			return nil, AppError{Code: 500, Message: "Failed to scan tool data"}
		}

		if desc.Valid {
			tool.Description = &desc.String
		}
		if imgURL.Valid {
			tool.ImageURL = &imgURL.String
		}

		tools = append(tools, tool)
	}

	return tools, nil
}

func (r *ToolRepository) GetByID(id int64) (*Tool, error) {
	var tool Tool
	var desc, imgURL sql.NullString

	err := r.db.QueryRow(
		"SELECT id, name, category, price_per_day, status, description, image_url FROM tools WHERE id = ?",
		id,
	).Scan(&tool.ID, &tool.Name, &tool.Category, &tool.PricePerDay, &tool.Status, &desc, &imgURL)

	if err == sql.ErrNoRows {
		return nil, AppError{Code: 404, Message: "Tool not found"}
	}
	if err != nil {
		return nil, AppError{Code: 500, Message: "Failed to fetch tool"}
	}

	if desc.Valid {
		tool.Description = &desc.String
	}
	if imgURL.Valid {
		tool.ImageURL = &imgURL.String
	}

	return &tool, nil
}

func (r *ToolRepository) Create(tool Tool) (*Tool, error) {
	result, err := r.db.Exec(
		"INSERT INTO tools (name, category, price_per_day, status, description, image_url) VALUES (?, ?, ?, ?, ?, ?)",
		tool.Name, tool.Category, tool.PricePerDay, tool.Status, tool.Description, tool.ImageURL,
	)
	if err != nil {
		return nil, AppError{Code: 500, Message: "Failed to create tool"}
	}

	id, err := result.LastInsertId()
	if err != nil {
		return nil, AppError{Code: 500, Message: "Failed to get tool ID"}
	}

	tool.ID = id
	return &tool, nil
}

func (r *ToolRepository) Update(id int64, tool Tool) (*Tool, error) {
	// Cek apakah tool exists terlebih dahulu
	existingTool, err := r.GetByID(id)
	if err != nil {
		return nil, err
	}

	// Merge data: gunakan nilai baru jika provided, otherwise gunakan nilai lama (Immutable approach)
	finalTool := mergeToolData(*existingTool, tool)

	_, err = r.db.Exec(
		"UPDATE tools SET name=?, category=?, price_per_day=?, status=?, description=?, image_url=? WHERE id=?",
		finalTool.Name, finalTool.Category, finalTool.PricePerDay, finalTool.Status, finalTool.Description, finalTool.ImageURL, id,
	)
	if err != nil {
		return nil, AppError{Code: 500, Message: "Failed to update tool"}
	}

	finalTool.ID = id
	return &finalTool, nil
}

// Pure function untuk merge data tool (Fungsi Murni)
func mergeToolData(existing, new Tool) Tool {
	result := existing

	if new.Name != "" {
		result.Name = new.Name
	}
	if new.Category != "" {
		result.Category = new.Category
	}
	if new.PricePerDay > 0 {
		result.PricePerDay = new.PricePerDay
	}
	if new.Status != "" {
		result.Status = new.Status
	}
	if new.Description != nil {
		result.Description = new.Description
	}
	if new.ImageURL != nil {
		result.ImageURL = new.ImageURL
	}

	return result
}

func (r *ToolRepository) Delete(id int64) error {
	// Cek apakah tool exists terlebih dahulu
	_, err := r.GetByID(id)
	if err != nil {
		return err
	}

	_, err = r.db.Exec("DELETE FROM tools WHERE id = ?", id)
	if err != nil {
		return AppError{Code: 500, Message: "Failed to delete tool"}
	}
	return nil
}

// Handler functions dengan closure (Closure)
func MakeGetAllToolsHandler(repo Repository) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		// Concurrent data fetching (Functional Concurrency)
		var tools []Tool
		var err error
		var wg sync.WaitGroup
		var mutex sync.Mutex

		wg.Add(1)
		go func() {
			defer wg.Done()
			mutex.Lock()
			defer mutex.Unlock()
			tools, err = repo.GetAll()
		}()
		wg.Wait()

		if err != nil {
			handleError(w, err.(AppError))
			return
		}

		// Contoh penggunaan Map, Filter, Reduce
		availableTools := FilterTools(tools, func(t Tool) bool {
			return t.Status == "tersedia"
		})

		prefixedTools := MapTools(availableTools, TransformToolName("Alat:"))

		totalPrice := ReduceTools(prefixedTools, func(acc int, t Tool) int {
			return acc + t.PricePerDay
		}, 0)

		response := map[string]interface{}{
			"tools":       prefixedTools,
			"total_count": len(prefixedTools),
			"total_price": totalPrice,
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(response)
	}
}

func MakeGetToolHandler(repo Repository) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		vars := mux.Vars(r)
		id, err := strconv.ParseInt(vars["id"], 10, 64)
		if err != nil {
			handleError(w, AppError{Code: 400, Message: "Invalid tool ID"})
			return
		}

		tool, err := repo.GetByID(id)
		if err != nil {
			handleError(w, err.(AppError))
			return
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(tool)
	}
}

// Recursive function untuk validasi (Rekursi)
func validateTool(tool Tool, depth int) []string {
	var errors []string

	if depth > 3 { // Base case untuk mencegah infinite recursion
		return errors
	}

	if tool.Name == "" {
		errors = append(errors, "Name is required")
	}
	if tool.Category == "" {
		errors = append(errors, "Category is required")
	}
	if tool.PricePerDay <= 0 {
		errors = append(errors, "Price must be positive")
	}

	// Recursive call untuk validasi tambahan
	if len(errors) > 0 && depth < 2 {
		moreErrors := validateTool(tool, depth+1)
		errors = append(errors, moreErrors...)
	}

	return errors
}

func MakeCreateToolHandler(repo Repository) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		var tool Tool
		if err := json.NewDecoder(r.Body).Decode(&tool); err != nil {
			handleError(w, AppError{Code: 400, Message: "Invalid JSON"})
			return
		}

		// Set default status jika tidak provided
		if tool.Status == "" {
			tool.Status = "tersedia"
		}

		// Validasi dengan recursive function
		if errors := validateTool(tool, 0); len(errors) > 0 {
			handleError(w, AppError{Code: 400, Message: fmt.Sprintf("Validation errors: %v", errors)})
			return
		}

		createdTool, err := repo.Create(tool)
		if err != nil {
			handleError(w, err.(AppError))
			return
		}

		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(http.StatusCreated)
		json.NewEncoder(w).Encode(createdTool)
	}
}

func MakeUpdateToolHandler(repo Repository) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		vars := mux.Vars(r)
		id, err := strconv.ParseInt(vars["id"], 10, 64)
		if err != nil {
			handleError(w, AppError{Code: 400, Message: "Invalid tool ID"})
			return
		}

		var tool Tool
		if err := json.NewDecoder(r.Body).Decode(&tool); err != nil {
			handleError(w, AppError{Code: 400, Message: "Invalid JSON"})
			return
		}

		// Validasi partial dengan recursive function
		if errors := validatePartialTool(tool, 0); len(errors) > 0 {
			handleError(w, AppError{Code: 400, Message: fmt.Sprintf("Validation errors: %v", errors)})
			return
		}

		updatedTool, err := repo.Update(id, tool)
		if err != nil {
			handleError(w, err.(AppError))
			return
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(updatedTool)
	}
}

// Recursive function untuk validasi partial update
func validatePartialTool(tool Tool, depth int) []string {
	var errors []string

	if depth > 2 { // Base case
		return errors
	}

	if tool.Name == "" && tool.Category == "" && tool.PricePerDay == 0 &&
	   tool.Status == "" && tool.Description == nil && tool.ImageURL == nil {
		errors = append(errors, "No fields to update")
	}

	if tool.PricePerDay < 0 {
		errors = append(errors, "Price cannot be negative")
	}

	// Recursive call untuk validasi tambahan
	if len(errors) > 0 && depth < 1 {
		moreErrors := validatePartialTool(tool, depth+1)
		errors = append(errors, moreErrors...)
	}

	return errors
}

func MakeDeleteToolHandler(repo Repository) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		vars := mux.Vars(r)
		id, err := strconv.ParseInt(vars["id"], 10, 64)
		if err != nil {
			handleError(w, AppError{Code: 400, Message: "Invalid tool ID"})
			return
		}

		err = repo.Delete(id)
		if err != nil {
			handleError(w, err.(AppError))
			return
		}

		// Functional approach untuk response
		response := MapTools([]Tool{}, func(t Tool) Tool {
			return t
		}) // Empty transformasi untuk demonstrasi

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(map[string]interface{}{
			"message": "Tool deleted successfully",
			"id":      id,
			"empty_result": response, // Demonstrasi penggunaan Map
		})
	}
}

// Error handler (Higher Order Function)
func handleError(w http.ResponseWriter, err AppError) {
	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(err.Code)
	json.NewEncoder(w).Encode(err)
}

// Middleware function (Higher Order Function)
func LoggingMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		log.Printf("%s %s %s", r.RemoteAddr, r.Method, r.URL)
		next.ServeHTTP(w, r)
	})
}

// Health check handler (Pure Function)
func MakeHealthCheckHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		err := db.Ping()
		if err != nil {
			handleError(w, AppError{Code: 500, Message: "Database connection failed"})
			return
		}

		response := map[string]string{
			"status":    "healthy",
			"database":  "connected",
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(response)
	}
}

func main() {
	// Koneksi database
	db, err := sql.Open("mysql", "root:@tcp(localhost:3306)/alatdb?parseTime=true")
	if err != nil {
		log.Fatal("Database connection failed:", err)
	}
	defer db.Close()

	// Test koneksi
	if err := db.Ping(); err != nil {
		log.Fatal("Database ping failed:", err)
	}

	// Repository
	repo := NewToolRepository(db)

	// Router
	r := mux.NewRouter()

	// Routes
	r.HandleFunc("/tools", MakeGetAllToolsHandler(repo)).Methods("GET")
	r.HandleFunc("/tools/{id}", MakeGetToolHandler(repo)).Methods("GET")
	r.HandleFunc("/tools", MakeCreateToolHandler(repo)).Methods("POST")
	r.HandleFunc("/tools/{id}", MakeUpdateToolHandler(repo)).Methods("PUT")
	r.HandleFunc("/tools/{id}", MakeDeleteToolHandler(repo)).Methods("DELETE")
	r.HandleFunc("/health", MakeHealthCheckHandler(db)).Methods("GET")

	// Middleware
	r.Use(LoggingMiddleware)

	// Start server
	fmt.Println("Server running on :8080")
	log.Fatal(http.ListenAndServe(":8080", r))
}
