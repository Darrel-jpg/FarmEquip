package main

import (
    "log"
    "net/http"
    "os"
    "farmequip_api/database"
)

func main() {
    db := database.ConnectDB()
    defer db.Close()

    cld, err := database.InitCloudinary()
    if err != nil {
        log.Fatal("Cloudinary gagal init:", err)
    }

    SetupRoutes(db, cld)

    port := os.Getenv("PORT")
    if port == "" {
        port = "8080"
    }

    log.Println("Server berjalan di port:", port)
    log.Fatal(http.ListenAndServe(":"+port, nil))
}