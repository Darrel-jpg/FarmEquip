package database

import (
	"database/sql"
	"fmt"
	"log"
	"os"
	_ "github.com/go-sql-driver/mysql"
)


func ConnectDB() *sql.DB {
	dbUser := os.Getenv("DB_USER")
	dbPass := os.Getenv("DB_PASS")
	dbHost := os.Getenv("DB_HOST")
	dbPort := os.Getenv("DB_PORT")
	dbName := os.Getenv("DB_NAME")

	// Format DSN MySQL
	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true",
		dbUser,
		dbPass,
		dbHost,
		dbPort,
		dbName,
	)

	db, err := sql.Open("mysql", dsn)
	if err != nil {
		log.Fatal("Koneksi gagal:", err)
	}

	if err := db.Ping(); err != nil {
		log.Fatal("Ping gagal:", err)
	}

	log.Println("Database terkoneksi ke:", dbName)

	return db
}
