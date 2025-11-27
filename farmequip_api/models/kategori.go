package models


type Kategori struct {
    ID           int    `json:"id"`
    NamaKategori string `json:"nama_kategori"`
    Deskripsi    string `json:"deskripsi"`
    Slug         string `json:"slug"`
}
