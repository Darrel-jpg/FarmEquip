package main

import (
	"database/sql"
	"fmt"
	"log"

	_ "github.com/go-sql-driver/mysql"
)

func ConnectDB() *sql.DB {

	dbUser := "root"
	dbPass := ""
	dbHost := "127.0.0.1"
	dbPort := "3306"
	dbName := "FarmEquip"

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s",
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

	log.Println("Database terkoneksi.")

	return db
}
