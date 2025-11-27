package main

import (
	"log"
	"net/http"
)

func main() {
	db := ConnectDB()
	defer db.Close()

	SetupRoutes(db)

	log.Println("Server berjalan di port 8080...")
	http.ListenAndServe(":8080", nil)
}
