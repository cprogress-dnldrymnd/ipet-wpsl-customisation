# iPet WPSL Customisation

A WordPress plugin that customises [WP Store Locator](https://wordpress.org/plugins/wp-store-locator/) (WPSL) for the iPet site.

## Features

- **Custom listing template** — registers a `Custom template` option and overrides the store listing markup (thumbnail, header, distance with pin icon, Directions + Full Details buttons).
- **CSV store importer** — adds a *Tools → Import WPSL Stores* admin page that imports stores from a CSV, geocodes each address via the Google Maps Geocoding API, and assigns "course" taxonomy terms under a parent category.
- **Diamond Centre feature** — a per-store "Diamond Centre" checkbox (store edit screen), a frontend filter to show Diamond Centres only, badges in the store list, and badge injection into the Full Details Elementor popup (`#7730`).

## Requirements

- WordPress 5.0+
- PHP 7.4+
- [WP Store Locator](https://wordpress.org/plugins/wp-store-locator/) installed and active
- A Google Maps API key configured in WPSL settings (required for the importer's geocoding)

## Installation

1. Copy the `ipet-wpsl-customisation` folder into `wp-content/plugins/`.
2. Activate **iPet WPSL Customisation** from the Plugins screen.

## Notes

- The custom template registration points at `get_stylesheet_directory() . '/wpsl-templates/custom.php'`, so the matching `custom.php` template must exist in the **active theme** (`wpsl-templates/custom.php`). This is intentional WPSL behaviour and is left as-is.
- The CSV importer expects columns such as `name`, `email`, `tel`, `address1`, `address2`, `city`, `county`, `country`, `postcode`, `website`, `bio`, and `course 1`…`course 12`. The parent category term ID is hard-coded to `249`, and the Diamond Centre popup ID is `7730` — adjust these in the source if your site differs.
