package models

type User struct {
	ID       int    `json:"id"`
	Nama     string `json:"nama"`
	Email    string `json:"email"`
	Username string `json:"username"`
	Password string `json:"password,omitempty"`
}
