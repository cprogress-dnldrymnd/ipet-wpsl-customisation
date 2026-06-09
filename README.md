# iPet WPSL Customisation

A WordPress plugin that customises [WP Store Locator](https://wordpress.org/plugins/wp-store-locator/) (WPSL) for the iPet site.

## Features

- **Custom listing template** — registers a `Custom template` option and overrides the store listing markup (thumbnail, header, distance with pin icon, Directions + Full Details buttons).
- **CSV store importer** — adds a *Tools → Import WPSL Stores* admin page that imports stores from a CSV, geocodes each address via the Google Maps Geocoding API, and assigns "course" taxonomy terms under a parent category.
- **Diamond Centre feature** — a per-store "Diamond Centre" checkbox (store edit screen), a frontend filter to show Diamond Centres only, badges in the store list, and badge injection into the Full Details Elementor popup (`#7730`).
- **Search UX scripts** — syncs the custom Qualification dropdowns onto WPSL's built-in category checkbox filter (so picking a dropdown value drives the actual filtering), and locks a chosen Elementor popup (non-dismissible) on a chosen page.
- **Qualification → category sync** — mirrors each `qualifications` post into a `wpsl_store_category` term under parent `249`: creates/updates the matching term on save and deletes it when the post is trashed.
- **Deep-link prefill + auto-search** — prefills the search box from a `?postcode=` URL parameter and auto-runs the search when `?qualification_of_interest=` is present (the companion to the template's dropdown pre-selection).
- **Get Started form gate** — sets a 30-day `get_started_form_submitted` cookie the first time the Elementor form with DOM id `get_started_form` is submitted successfully, and on `page-id-6565` auto-opens Elementor popup `#7822` for non-admin visitors who haven't submitted yet (admins and converted visitors skip it and get a `show--body` body class that reveals the page). Pairs with the popup-lock that makes `#7822` non-dismissible.

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
- The front-end scripts (injected via `wp_footer`) include a dropdown→checkbox sync that depends on the `.wpsl-input--custom-category` selects (from the bundled template) and WPSL's `#wpsl-checkbox-filter`, plus a popup-lock that targets Elementor popup ID `7822` on page ID `6565` (`page-id-6565`) — adjust the popup/page IDs in the source if your site differs.
- The Qualification → category sync hooks the `qualifications` custom post type (which must be registered elsewhere), stores the linked term ID in the `_linked_wpsl_term_id` post meta, and parents new terms under category ID `249` (the same parent the CSV importer uses) — change `249` in the source if your taxonomy differs.
- The deep-link prefill reads the `postcode` and `qualification_of_interest` query parameters. The `postcode` value is sanitised (`sanitize_text_field`) and escaped (`esc_js`) before it is written into the page, to prevent reflected XSS — the original Elementor snippet echoed it raw.
- The Get Started form gate matches the Elementor form by its DOM id `get_started_form` and writes a `get_started_form_submitted=true` cookie (30-day expiry, `path=/`, `SameSite=Lax`); the gated popup is `#7822` on `page-id-6565` and the reveal hook is the `show--body` body class — adjust the form id, popup/page ids, expiry, or reveal class in the source if your site differs. The popup-lock block targets the same `#7822` / `page-id-6565`. The page-reveal assumes your theme CSS hides the page until `body.show--body` is set; without that CSS the page is always visible and the gate only controls whether the popup auto-opens.
