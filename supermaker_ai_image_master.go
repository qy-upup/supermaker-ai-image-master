package supermaker_ai_image_master

import (
	"fmt"
	"net/url"
	"strings"
)

// LinkBuilder is used to create tracked links with UTM parameters
type LinkBuilder struct {
	BaseURL string
}

// NewLinkBuilder creates a new LinkBuilder instance
func NewLinkBuilder(baseURL string) *LinkBuilder {
	return &LinkBuilder{
		BaseURL: baseURL,
	}
}

// BuildLink creates a link with optional UTM parameters
func (lb *LinkBuilder) BuildLink(utmSource, utmMedium, utmCampaign string) string {
	u, err := url.Parse(lb.BaseURL)
	if err != nil {
		return lb.BaseURL
	}

	q := u.Query()
	if utmSource != "" {
		q.Set("utm_source", utmSource)
	}
	if utmMedium != "" {
		q.Set("utm_medium", utmMedium)
	}
	if utmCampaign != "" {
		q.Set("utm_campaign", utmCampaign)
	}

	u.RawQuery = q.Encode()
	return u.String()
}

// GenerateAnchor generates an HTML anchor tag
func (lb *LinkBuilder) GenerateAnchor(text string, opts ...AnchorOption) string {
	href := lb.BaseURL
	rel := "nofollow"
	target := "_blank"
	className := ""

	for _, opt := range opts {
		opt(&href, &rel, &target, &className)
	}

	classAttr := ""
	if className != "" {
		classAttr = fmt.Sprintf(" class=\"%s\"", htmlEscape(className))
	}

	return fmt.Sprintf(
		"<a href=\"%s\" rel=\"%s\" target=\"%s\"%s>%s</a>",
		htmlEscape(href),
		htmlEscape(rel),
		htmlEscape(target),
		classAttr,
		htmlEscape(text),
	)
}

// AnchorOption is a functional option for GenerateAnchor
type AnchorOption func(*string, *string, *string, *string)

// WithUTM sets UTM parameters
func WithUTM(source, medium, campaign string) AnchorOption {
	return func(href, rel, target, className *string) {
		u, _ := url.Parse(*href)
		q := u.Query()
		if source != "" {
			q.Set("utm_source", source)
		}
		if medium != "" {
			q.Set("utm_medium", medium)
		}
		if campaign != "" {
			q.Set("utm_campaign", campaign)
		}
		u.RawQuery = q.Encode()
		*href = u.String()
	}
}

// WithClass sets the CSS class
func WithClass(class string) AnchorOption {
	return func(href, rel, target, className *string) {
		*className = class
	}
}

// WithRel sets the rel attribute
func WithRel(r string) AnchorOption {
	return func(href, rel, target, className *string) {
		*rel = r
	}
}

// WithTarget sets the target attribute
func WithTarget(t string) AnchorOption {
	return func(href, rel, target, className *string) {
		*target = t
	}
}

func htmlEscape(s string) string {
	s = strings.ReplaceAll(s, "&", "&amp;")
	s = strings.ReplaceAll(s, "<", "&lt;")
	s = strings.ReplaceAll(s, ">", "&gt;")
	s = strings.ReplaceAll(s, "\"", "&quot;")
	s = strings.ReplaceAll(s, "'", "&#39;")
	return s
}
