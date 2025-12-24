package supermaker_ai_image_master

import (
	"testing"
)

func TestBuildLink(t *testing.T) {
	builder := NewLinkBuilder("https://example.com")
	link := builder.BuildLink("newsletter", "email", "spring-2025")

	if !strings.Contains(link, "utm_source=newsletter") {
		t.Errorf("Expected utm_source in link, got %s", link)
	}
}

func TestGenerateAnchor(t *testing.T) {
	builder := NewLinkBuilder("https://example.com")
	html := builder.GenerateAnchor("Click here", WithClass("btn"))

	if !strings.Contains(html, "class=") {
		t.Errorf("Expected class attribute in anchor, got %s", html)
	}
}
