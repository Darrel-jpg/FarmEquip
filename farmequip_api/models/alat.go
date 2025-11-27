package models

type Alat struct {
	ID            int    `json:"id"`
	NamaAlat      string `json:"nama_alat"`
	KategoriID    int    `json:"kategori_id"`
	NamaKategori  string `json:"nama_kategori"` // tambahan
	Deskripsi     string `json:"deskripsi"`
	HargaHarian   int    `json:"harga_per_hari"`
	HargaMingguan int    `json:"harga_per_minggu"`
	HargaBulanan  int    `json:"harga_per_bulan"`
	Gambar        string `json:"gambar"` // BASE64
}
