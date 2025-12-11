package database

import (
    "os"
    "github.com/cloudinary/cloudinary-go/v2"
)

func InitCloudinary() (*cloudinary.Cloudinary, error) {
    return cloudinary.NewFromParams(
        os.Getenv("CLOUD_NAME"),
        os.Getenv("CLOUD_KEY"),
        os.Getenv("CLOUD_SECRET"),
    )
}
