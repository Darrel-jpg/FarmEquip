<<<<<<< HEAD
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
=======
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
>>>>>>> aad9e9c16073a1cd1a352ff8da6010409bc02900
