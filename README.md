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

- The custom search template (`wpsl-templates/custom.php`) is now **bundled inside this plugin**; the `wpsl_templates` registration points at `plugin_dir_path( __FILE__ ) . 'wpsl-templates/custom.php'`, so it no longer depends on a copy living in the active theme. If an old `wpsl-templates/custom.php` still exists in your theme it is now redundant and can be removed. The registered template id (`custom`) is unchanged, so the existing selection in **WPSL → Settings → Search** stays valid.
- The CSV importer expects columns such as `name`, `email`, `tel`, `address1`, `address2`, `city`, `county`, `country`, `postcode`, `website`, `bio`, and `course 1`…`course 12`. The parent category term ID is hard-coded to `249`, and the Diamond Centre popup ID is `7730` — adjust these in the source if your site differs.
