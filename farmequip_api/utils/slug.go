package utils

import (
    "regexp"
    "strings"
)

func GenerateSlug(s string) string {
    s = strings.ToLower(s)
    s = strings.ReplaceAll(s, " ", "-")

    // hapus karakter non-alfanumerik
    reg := regexp.MustCompile(`[^a-z0-9\-]+`)
    s = reg.ReplaceAllString(s, "")

    return s
}
