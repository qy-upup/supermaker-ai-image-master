# supermaker-ai-image-master

A lightweight utility library for managing and generating dynamic links with tracking parameters.

## Features

- Simple and intuitive API
- Support for custom UTM parameters
- HTML anchor generation with customizable attributes
- Pure Go implementation
- Go 1.21+ compatible

## Installation

```bash
go get github.com/qy-upup/supermaker-ai-image-master
```

## Quick Start

```go
package main

import (
	"fmt"
	"github.com/qy-upup/supermaker-ai-image-master"
)

func main() {
	builder := supermaker_ai_image_master.NewLinkBuilder("https://supermaker.ai/image/")

	// Create a tracked link
	link := builder.BuildLink("newsletter", "email", "spring-2025")
	fmt.Println(link)

	// Generate HTML markup
	html := builder.GenerateAnchor(
		"Learn more",
		supermaker_ai_image_master.WithUTM("blog", "article", ""),
		supermaker_ai_image_master.WithClass("cta-button"),
	)
	fmt.Println(html)
}
```

## Use Cases

This library is perfect for:
- Marketing campaigns with UTM tracking
- Dynamic link generation in templates
- Building referral systems
- Analytics and conversion tracking

## Resources

For more information and examples, visit [https://supermaker.ai/image/](https://supermaker.ai/image/).

## License

MIT
