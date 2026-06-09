<?php
/**
 * Plugin Name:       iPet WPSL Customisation
 * Plugin URI:        https://github.com/cprogress-dnldrymnd/ipet-wpsl-customisation
 * Description:       Customisations for WP Store Locator: custom listing template, CSV importer with Google geocoding, and the Diamond Centre feature.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            cprogress
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ipet-wpsl-customisation
 *
 * @package iPet_WPSL_Customisation
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter('wpsl_templates', 'custom_templates');
function custom_templates($templates)
{

    /**
     * The 'id' is for internal use and must be unique ( since 2.0 ).
     * The 'name' is used in the template dropdown on the settings page.
     * The 'path' points to the location of the custom template,
     * in this case the wpsl-templates folder bundled inside this plugin
     * so the customisation is self-contained and theme-independent.
     */
    $templates[] = array(
        'id'   => 'custom',
        'name' => 'Custom template',
        'path' => plugin_dir_path( __FILE__ ) . 'wpsl-templates/custom.php',
    );

    return $templates;
}
/*
define( 'WPSL_MARKER_URI', dirname( get_bloginfo( 'stylesheet_url') ) . '/wpsl-templates/wpsl-markers/' );

function custom_admin_marker_dir()
{

    $admin_marker_dir = get_stylesheet_directory() . '/wpsl-templates/wpsl-markers/';

    return $admin_marker_dir;
}*/

add_filter('wpsl_listing_template', 'custom_listing_template');

function custom_listing_template()
{

    global $wpsl_settings, $wpsl;

    $listing_template = '<li class="store--listing"  data-store-id="<%= id %>">' . "\r\n";
    $listing_template .= "\t\t" . '<div>' . "\r\n";
    $listing_template .= "\t\t\t" . '<%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<h4>' . wpsl_store_header_template('listing') . '</h4>' . "\r\n";
	/*
    $listing_template .= "\t\t" . '<div class="address">' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span>' . "\r\n";
    $listing_template .= "\t\t\t" . '</div>' . "\r\n";

	/*
    if ($wpsl_settings['show_contact_details']) {
        $listing_template .= "\t\t\t" . '<div class="wpsl-contact-details">' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html($wpsl->i18n->get_translation('phone_label', __('Phone', 'wpsl'))) . '</strong>: <%= formatPhoneNumber( phone ) %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html($wpsl->i18n->get_translation('fax_label', __('Fax', 'wpsl'))) . '</strong>: <%= fax %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( email ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html($wpsl->i18n->get_translation('email_label', __('Email', 'wpsl'))) . '</strong>: <span class="email"><%= email %></span></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( url ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html($wpsl->i18n->get_translation('url_label', __('Website', 'wpsl'))) . '</strong>: <%= url %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '</div>' . "\r\n";
    }*/



    $listing_template .= "\t\t" . '</div>' . "\r\n";

    // Check if we need to show the distance.
    if (!$wpsl_settings['hide_distance']) {
        $listing_template .= "\t\t" . '<div class="distance"><svg xmlns="http://www.w3.org/2000/svg" width="15.471" height="17.357" viewBox="0 0 15.471 17.357">
  <path id="pin-svgrepo-com_5_" data-name="pin-svgrepo-com (5)" d="M10.735,2A7.735,7.735,0,0,0,3,9.735,9.153,9.153,0,0,0,5.558,15.62a20.072,20.072,0,0,0,3.883,3.343,2.327,2.327,0,0,0,2.589,0,20.072,20.072,0,0,0,3.883-3.343,9.153,9.153,0,0,0,2.558-5.885A7.735,7.735,0,0,0,10.735,2ZM9.016,9.735a1.719,1.719,0,1,1,1.719,1.719A1.719,1.719,0,0,1,9.016,9.735ZM10.735,6.3a3.438,3.438,0,1,0,3.438,3.438A3.438,3.438,0,0,0,10.735,6.3Z" transform="translate(-3 -2)" fill="#028e94" fill-rule="evenodd"/>
</svg> <%= distance %> ' . esc_html($wpsl_settings['distance_unit']) . '</div>' . "\r\n";
    }
    $listing_template .= "<div class='listing--buttons row'>";
    $listing_template .= "\t\t" . '<div class="btn--listing btn-direction col-lg-6"><%= createDirectionUrl() %></div>' . "\r\n";
    $listing_template .= "<div class='btn--listing btn-full-details col-lg-6'><a class='store--full-details-trigger'> Full Details <span class='wpcf7-spinner'></span></a></div>";
    $listing_template .= "</div>";

    $listing_template .= "\t" . '</li>' . "\r\n";

    return $listing_template;
}

#add_filter('wpsl_admin_marker_dir', 'custom_admin_marker_dir');


/**
 * Get Google Maps Direction Link for a WP Store Locator Store
 *
 * @param int $post_id The ID of the store post.
 * @return string|false The Google Maps URL or false if coordinates are missing.
 */
function get_wpsl_direction_url( $post_id ) {
    $lat = get_post_meta( $post_id, 'wpsl_lat', true );
    $lng = get_post_meta( $post_id, 'wpsl_lng', true );

    if ( empty( $lat ) || empty( $lng ) ) {
        return false;
    }

    return 'https://www.google.com/maps/dir/?api=1&destination=' . $lat . ',' . $lng;
}

function get_wpsl_full_address($store_id) {

	$street   = get_post_meta( $store_id, 'wpsl_address', true );
	$street2  = get_post_meta( $store_id, 'wpsl_address2', true );
	$city     = get_post_meta( $store_id, 'wpsl_city', true );
	$state    = get_post_meta( $store_id, 'wpsl_state', true );
	$zip      = get_post_meta( $store_id, 'wpsl_zip', true );
	$country  = get_post_meta( $store_id, 'wpsl_country', true );

	$full_address = $street;
	if ( $street2 ) { $full_address .= ', ' . $street2; }
	$full_address .= ', ' . $city . ', ' . $state . ' ' . $zip . ', ' . $country;

	return $full_address;
}

/**
 * Register the Import Page
 */
function wpsl_register_import_page() {
    add_management_page('Import WPSL Stores', 'Import WPSL Stores', 'manage_options', 'wpsl-csv-import', 'wpsl_render_import_page');
}
add_action('admin_menu', 'wpsl_register_import_page');

/**
 * Render HTML Form
 */
function wpsl_render_import_page() {
    ?>
    <div class="wrap">
        <h1>Import Stores (with Geocoding)</h1>
        <p>This will import stores and automatically calculate Latitude/Longitude based on the address.</p>
        <?php
        if (isset($_POST['wpsl_import_nonce_field']) && wp_verify_nonce($_POST['wpsl_import_nonce_field'], 'wpsl_import_action')) {
            wpsl_process_csv_import();
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('wpsl_import_action', 'wpsl_import_nonce_field'); ?>
            <input type="file" name="csv_file" required accept=".csv"><br><br>
            <input type="submit" name="submit_csv" class="button button-primary" value="Start Import">
        </form>
    </div>
    <?php
}

/**
 * Helper: Geocode Address using Google Maps API
 */
function wpsl_get_coordinates_from_address($address) {
    $wpsl_settings = get_option('wpsl_settings');
    $api_key = isset($wpsl_settings['api_key']) ? $wpsl_settings['api_key'] : '';

    if (empty($api_key)) {
        return false;
    }

    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $api_key;
    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if ($data->status === 'OK') {
        return [
            'lat' => $data->results[0]->geometry->location->lat,
            'lng' => $data->results[0]->geometry->location->lng
        ];
    }

    return false;
}

/**
 * Process Import
 */
function wpsl_process_csv_import() {
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== 0) return;

    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, 'r');
    if ($handle === false) return;

    set_time_limit(0);
    
    $headers = fgetcsv($handle);
    $headers = array_map(function($h) { return strtolower(trim($h)); }, $headers);

    $meta_map = [
        'email' => 'wpsl_email', 'tel' => 'wpsl_phone', 'address1' => 'wpsl_address',
        'address2' => 'wpsl_address2', 'city' => 'wpsl_city', 'county' => 'wpsl_state',
        'country' => 'wpsl_country', 'postcode' => 'wpsl_zip', 'website' => 'wpsl_url'
    ];

    $count = 0;
    $parent_cat_id = 249;

    while (($row = fgetcsv($handle)) !== false) {
        if (count($headers) !== count($row)) continue;
        $data = array_combine($headers, $row);

        $post_title = isset($data['name']) ? sanitize_text_field($data['name']) : '';
        $post_content = isset($data['bio']) ? wp_kses_post($data['bio']) : '';

        if (empty($post_title)) continue;

        $existing = get_page_by_title($post_title, OBJECT, 'wpsl_stores');
        if ($existing) {
            $post_id = $existing->ID;
        } else {
            $post_id = wp_insert_post([
                'post_title' => $post_title,
                'post_content' => $post_content,
                'post_type' => 'wpsl_stores',
                'post_status' => 'publish'
            ]);
        }

        if ($post_id) {
            $count++;

            foreach ($meta_map as $header => $key) {
                if (isset($data[$header])) update_post_meta($post_id, $key, sanitize_text_field($data[$header]));
            }

            $address_parts = [
                $data['address1'] ?? '',
                $data['city'] ?? '',
                $data['county'] ?? '',
                $data['postcode'] ?? '',
                $data['country'] ?? ''
            ];
            $full_address = implode(', ', array_filter($address_parts));

            $coords = wpsl_get_coordinates_from_address($full_address);

            if ($coords) {
                update_post_meta($post_id, 'wpsl_lat', $coords['lat']);
                update_post_meta($post_id, 'wpsl_lng', $coords['lng']);
            }

            $terms_to_assign = [];
            for ($i = 1; $i <= 12; $i++) {
                $col = strtolower("course $i");
                if (!empty($data[$col])) {
                    $t_name = sanitize_text_field($data[$col]);
                    $term = term_exists($t_name, 'wpsl_store_category', $parent_cat_id);
                    if ($term) {
                        $t_id = is_array($term) ? $term['term_id'] : $term;
                    } else {
                        $new = wp_insert_term($t_name, 'wpsl_store_category', ['parent' => $parent_cat_id]);
                        $t_id = !is_wp_error($new) ? $new['term_id'] : null;
                    }
                    if ($t_id) $terms_to_assign[] = (int)$t_id;
                }
            }
            if (!empty($terms_to_assign)) wp_set_object_terms($post_id, $terms_to_assign, 'wpsl_store_category');
            
            usleep(200000);
        }
    }
    fclose($handle);
    echo '<div class="notice notice-success"><p>Done! Processed ' . $count . ' stores.</p></div>';
}


// =============================================
// QUALIFICATION CPT  <->  wpsl_store_category SYNC
//   Keeps a `wpsl_store_category` term (child of parent 249) in sync with each
//   `qualifications` post: create/update the term on save, delete it on trash.
//   The link is stored on the qualification post via meta `_linked_wpsl_term_id`.
// =============================================

/**
 * 1. CREATE/UPDATE: Sync Qualification to wpsl_store_category
 * Works with Gutenberg autosaves and updates.
 */
add_action('save_post_qualifications', 'sync_qualification_to_wpsl_term', 10, 3);

function sync_qualification_to_wpsl_term($post_id, $post, $update) {
    // Ignore autosaves and revisions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    // Ignore if post status is 'trash' or 'auto-draft' (prevents creating terms for empty drafts)
    if ($post->post_status === 'trash' || $post->post_status === 'auto-draft') return;

    $taxonomy = 'wpsl_store_category';
    $term_name = $post->post_title; // Use title directly from object
    $parent_id = 249;

    // Ensure title isn't empty (Gutenberg sometimes saves empty initial drafts)
    if (empty($term_name)) return;

    $linked_term_id = get_post_meta($post_id, '_linked_wpsl_term_id', true);

    if ($linked_term_id && term_exists((int)$linked_term_id, $taxonomy)) {
        // UPDATE existing term
        wp_update_term($linked_term_id, $taxonomy, [
            'name' => $term_name,
            'slug' => sanitize_title($term_name),
            'parent' => $parent_id
        ]);
    } else {
        // CREATE new term (with safety check)
        $existing_term = term_exists($term_name, $taxonomy);

        if ($existing_term) {
            // If term exists by name, just link it
            $term_id = is_array($existing_term) ? $existing_term['term_id'] : $existing_term;
        } else {
            // Create fresh
            $result = wp_insert_term($term_name, $taxonomy, [
                'parent' => $parent_id
            ]);

            if (is_wp_error($result)) return;
            $term_id = $result['term_id'];
        }

        update_post_meta($post_id, '_linked_wpsl_term_id', $term_id);
    }
}

/**
 * 2. DELETE: Remove wpsl_store_category when Qualification is Trashed
 * Uses 'transition_post_status' for better Gutenberg/REST API support.
 */
add_action('transition_post_status', 'handle_qualification_trash_wpsl', 10, 3);

function handle_qualification_trash_wpsl($new_status, $old_status, $post) {
    // Only run for 'qualifications' post type
    if ($post->post_type !== 'qualifications') {
        return;
    }

    // Check if the post is entering the 'trash'
    if ($new_status === 'trash') {
        $taxonomy = 'wpsl_store_category';
        $parent_id = 249;

        // METHOD A: Try to delete using the saved Link ID
        $linked_term_id = get_post_meta($post->ID, '_linked_wpsl_term_id', true);

        if ($linked_term_id) {
            $term = get_term((int)$linked_term_id, $taxonomy);
            if ($term && !is_wp_error($term)) {
                wp_delete_term($term->term_id, $taxonomy);
            }
        }
        // METHOD B: Fallback (if no link ID exists, e.g., old posts)
        else {
            // Find term by Name
            $term = get_term_by('name', $post->post_title, $taxonomy);

            // Only delete if it exists AND is a child of the specific parent ID (Safety)
            if ($term && !is_wp_error($term) && (int)$term->parent === $parent_id) {
                wp_delete_term($term->term_id, $taxonomy);
            }
        }
    }
}


// =============================================
// DIAMOND CENTER FEATURE
// =============================================

/**
 * 1. Add Diamond Center meta box to the store edit screen (WP Admin sidebar)
 */
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'diamond_center_meta_box',
        'Diamond Centre',
        function( $post ) {
            $value = get_post_meta( $post->ID, 'is_diamond_center', true );
            echo '<label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="is_diamond_center" value="1" ' . checked( $value, '1', false ) . '>
                <span>This store is a Diamond Centre</span>
            </label>';
        },
        'wpsl_stores',
        'side',
        'default'
    );
});

/**
 * 2. Save the Diamond Center checkbox value when the store post is saved
 */
add_action( 'save_post_wpsl_stores', function( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $value = isset( $_POST['is_diamond_center'] ) ? '1' : '0';
    update_post_meta( $post_id, 'is_diamond_center', $value );
});

/**
 * 3. Output Diamond Center store IDs as a JS variable.
 *    Priority 5 ensures this runs before the scripts below.
 */
add_action( 'wp_footer', function() {
    $diamond_stores = get_posts([
        'post_type'      => 'wpsl_stores',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [[
            'key'   => 'is_diamond_center',
            'value' => '1',
        ]],
        'fields' => 'ids',
    ]);

    $map = [];
    foreach ( $diamond_stores as $id ) {
        $map[ $id ] = true;
    }

    echo '<script>window.diamondCenterStores = ' . json_encode( $map ) . ';</script>';
}, 5 );

/**
 * 4. Frontend: Filter checkbox + badge injection + list & map marker filtering
 *    + Diamond Centre badge inside Full Details (Elementor popup 7730)
 */
add_action( 'wp_footer', function() {
    ?>
    <style>
        .diamond-center-badge {
            display: flex;
            align-items: center;
            background: #EBF4FF;
            padding: 4px 10px;
            border-radius: 5px;
            color: #2859C5;
            text-transform: capitalize;
            font-size: 12px;
            font-weight: 600;
            width: fit-content;
            letter-spacing: normal;
            margin-bottom: 10px;
            gap: 4px;
        }
        #store--details-popup .diamond-center-badge {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .diamond-center-badge .icon {
            display: flex;
            width: 15px;
            height: fit-content;
        }
        .diamond-center-badge .icon svg {
            display: flex;
            width: 100%;
            height: auto;
        }
        .diamond-center-filter-wrap {
            margin: 10px 0 15px;
            display: none;
        }
        .diamond-center-filter-wrap label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #028e94;
        }
        .diamond-center-filter-wrap input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #028e94;
        }
        .diamond-icon-text {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .diamond-icon-text .icon {
            display: flex;
            width: 15px;
            height: fit-content;
        }
        .diamond-icon-text .icon svg {
            display: flex;
            width: 100%;
            height: auto;
        }
        .diamond-icon-text .text {
            font-size: 13px;
            font-weight: 600;
            color: #2859C5;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {

        // -------------------------------------------------------
        // SHARED: Diamond badge SVG helper (avoids repetition)
        // -------------------------------------------------------
        var diamondSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16.258" height="13.455" viewBox="0 0 16.258 13.455">
            <g transform="translate(-2.195 -6.393)">
                <path id="Path_1218" data-name="Path 1218" d="M17.777,10.932l-1.91-3.387A1.071,1.071,0,0,0,14.934,7H5.714a1.071,1.071,0,0,0-.932.545L2.871,10.932a1.071,1.071,0,0,0,.175,1.283l6.773,6.773a.714.714,0,0,0,1.009,0L17.6,12.215a1.071,1.071,0,0,0,.176-1.283Z" transform="translate(0 0)" fill="#8fbffa"/>
                <path id="Path_1219" data-name="Path 1219" d="M17.777,10.932l-1.91-3.387A1.071,1.071,0,0,0,14.934,7H5.714a1.071,1.071,0,0,0-.932.545L2.871,10.932a1.071,1.071,0,0,0,.175,1.283l6.773,6.773a.714.714,0,0,0,1.009,0L17.6,12.215a1.071,1.071,0,0,0,.176-1.283Z" transform="translate(0 0)" fill="none" stroke="#2859c5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                <path id="Path_1220" data-name="Path 1220" d="M16.794,7l-1.055,4.191a1.428,1.428,0,0,0,.06.88L18.657,19.2h.006" transform="translate(-8.336 0)" fill="none" stroke="#2859c5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                <path id="Path_1221" data-name="Path 1221" d="M12.362,7l1.055,4.191a1.428,1.428,0,0,1-.059.88L10.5,19.2M3,11.64H17.992" transform="translate(-0.172 0)" fill="none" stroke="#2859c5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
            </g>
        </svg>
        `;

        var diamondBadgeHTML = '<div class="diamond-center-badge">'
            + '<span class="icon">' + diamondSVG + '</span>'
            + '<span class="text">Diamond Centre</span>'
            + '</div>';

        // -------------------------------------------------------
        // TRACK which store's "Full Details" was last clicked
        // FIX: this was missing, causing lastClickedStoreId ReferenceError
        // -------------------------------------------------------
        var lastClickedStoreId = null;

        $(document).on('click', '.store--full-details-trigger', function() {
            var $li = $(this).closest('.store--listing');
            lastClickedStoreId = $li.data('store-id') || null;
        });

        // -------------------------------------------------------
        // FULL DETAILS POPUP: inject badge on Elementor popup open
        // Uses setTimeout to wait for popup content to fully render
        // -------------------------------------------------------
        $(document).on('elementor/popup/show', function(event, id, instance) {
            if (id !== 7730) return;

            // Small delay to ensure popup content is fully rendered
            setTimeout(function() {
                var $modal = $('#elementor-popup-modal-7730 .dialog-lightbox-message');

                // Remove any previously injected badge
                $modal.find('.diamond-center-badge').remove();

                if (
                    lastClickedStoreId &&
                    window.diamondCenterStores &&
                    window.diamondCenterStores[lastClickedStoreId]
                ) {
                    $modal.find('h1, h2, h3, h4').first().before(diamondBadgeHTML);
                }
            }, 200);
        });

        // -------------------------------------------------------
        // STORE LIST: inject filter checkbox above the store list
        // -------------------------------------------------------
        function injectDiamondFilter() {
            if ($('#diamond-center-filter').length === 0 && $('.store--listing').length > 0) {
                $('#wpsl-stores').before(
                    '<div class="diamond-center-filter-wrap" id="diamond-filter-wrap">'
                    + '<label>'
                    + '<input type="checkbox" id="diamond-center-filter">'
                    + '<div class="diamond-icon-text">'
                    + '<span class="icon">' + diamondSVG + '</span>'
                    + '<span class="text">Display Diamond Centre\'s Only</span>'
                    + '</div>'
                    + '</label>'
                    + '</div>'
                );
            }
            if ($('.store--listing').length > 0) {
                $('#diamond-filter-wrap').show();
            }
        }

        // -------------------------------------------------------
        // STORE LIST: inject Diamond Centre badge above store title
        // -------------------------------------------------------
        function injectDiamondBadges() {
            $('.store--listing').each(function() {
                var $li = $(this);
                if ($li.find('.diamond-center-badge').length > 0) return;

                var storeId = $li.data('store-id');
                if (!storeId) return;

                if (window.diamondCenterStores && window.diamondCenterStores[storeId]) {
                    $li.find('h4').first().before(diamondBadgeHTML);
                }
            });
        }

        // -------------------------------------------------------
        // FILTER: apply to store list + map markers
        // -------------------------------------------------------
        function applyDiamondFilter(checked) {

            // 1. Show/hide store list items
            $('.store--listing').each(function() {
                var storeId = $(this).data('store-id');
                var isDiamond = window.diamondCenterStores && window.diamondCenterStores[storeId];
                $(this).toggle(!checked || !!isDiamond);
            });

            // 2. Show/hide map markers via WPSL's internal marker array
            if (typeof wpsl !== 'undefined' && wpsl.maps && wpsl.maps.markers) {
                $.each(wpsl.maps.markers, function(i, marker) {
                    if (!marker) return;
                    var isDiamondMarker = window.diamondCenterStores && window.diamondCenterStores[marker.store_id];
                    marker.setVisible(!checked || !!isDiamondMarker);
                });
            }
        }

        // -------------------------------------------------------
        // MUTATION OBSERVER: re-run when WPSL loads new results
        // -------------------------------------------------------
        var observer = new MutationObserver(function() {
            injectDiamondFilter();
            injectDiamondBadges();

            if ($('#diamond-center-filter').is(':checked')) {
                applyDiamondFilter(true);
            }
        });

        var target = document.getElementById('wpsl-stores') || document.body;
        observer.observe(target, { childList: true, subtree: true });

        // -------------------------------------------------------
        // CHECKBOX CHANGE HANDLER
        // -------------------------------------------------------
        $(document).on('change', '#diamond-center-filter', function() {
            applyDiamondFilter($(this).is(':checked'));
        });

    });
    </script>
    <?php
}, 10 );


// =============================================
// CUSTOM CATEGORY DROPDOWNS -> WPSL CHECKBOX FILTER SYNC
//   The custom Qualification dropdowns rendered by wpsl-templates/custom.php
//   (.wpsl-input--custom-category select) are mirrored onto WPSL's built-in
//   category checkbox filter (#wpsl-checkbox-filter), so selecting a dropdown
//   value ticks the matching category checkbox WPSL actually filters on.
// =============================================
add_action( 'wp_footer', function () {
    ?>
    <script>
    jQuery(document).ready(function () {
        setTimeout(function () {
            update__categories();
        }, 2000);
        jQuery('.wpsl-input--custom-category select').change(function (e) {
            e.preventDefault();
            $val = jQuery(this).val();
            update__categories();
        });
    });

    function update__categories() {
        jQuery('#wpsl-checkbox-filter').find('input').prop('checked', false);
        jQuery('.wpsl-input--custom-category select').each(function (index, element) {
            $val = jQuery(this).val();
            if ($val != '') {
                jQuery('#wpsl-checkbox-filter').find('input[value=' + $val + ']').prop('checked', true);
            }
        });
    }
    </script>
    <?php
}, 10 );

// =============================================
// ELEMENTOR POPUP LOCK
//   Makes Elementor popup #7822 non-dismissible on page-id-6565:
//   disables overlay click + ESC key and hides the close button.
//   Change the popup ID (7822) / page ID (6565) below to match your site.
// =============================================
add_action( 'wp_footer', function () {
    ?>
    <script>
    jQuery(document).on('elementor/popup/show', function (event, id) {
        // 1. DO NOT affect admins (checks if the admin bar is present)
       //         if (jQuery('body').hasClass('admin-bar')) return;

        // Only target THIS popup
        if (id !== 7822) return;

        // Only disable closing on a specific page
        if (!jQuery('body').hasClass('page-id-6565')) return; // ← change ID

        const $popup = jQuery('.elementor-popup-modal');

        // ❌ Disable overlay click
        $popup.off('click');

        // ❌ Disable ESC key
        jQuery(document).off('keydown.elementorPopup');

        // ❌ Hide close button
        $popup.find('.dialog-close-button').hide();
    });
    </script>
    <?php
}, 10 );


// =============================================
// DEEP-LINK PREFILL + AUTO-SEARCH
//   When the locator page is reached with query args, prefill the search box
//   from ?postcode= and (if ?qualification_of_interest= is present) auto-run the
//   search after a short delay. Pairs with the $_GET handling in
//   wpsl-templates/custom.php that pre-selects the qualification dropdowns.
//
//   NOTE: the original snippet echoed $_GET['postcode'] straight into the page
//   (reflected XSS). The value is now sanitised + esc_js()'d before output;
//   behaviour for legitimate postcodes is unchanged.
// =============================================
add_action( 'wp_footer', function () {
    ?>
    <script>
    jQuery(document).ready(function() {
        <?php if ( isset( $_GET['postcode'] ) ) {
            $wpsl_prefill_postcode = sanitize_text_field( wp_unslash( $_GET['postcode'] ) ); ?>
            jQuery('#wpsl-search-input').val('<?php echo esc_js( $wpsl_prefill_postcode ); ?>');
        <?php } ?>

        <?php if ( isset( $_GET['qualification_of_interest'] ) ) { ?>
            setTimeout(function() {
                jQuery('#wpsl-search-btn').trigger('click');
            }, 1000);
        <?php } ?>
    });
    </script>
    <?php
}, 10 );


// =============================================
// GET STARTED FORM — 30-DAY COOKIE + GATED POPUP (#7822 on page-id-6565)
//   Two halves of the same gate:
//   1. Drops a `get_started_form_submitted` cookie (30-day expiry) the first
//      time the Elementor form with DOM id `get_started_form` is submitted
//      successfully. Elementor's `submit_success` event fires for every form,
//      so we match on the form id.
//   2. On page-id-6565, auto-opens Elementor popup #7822 for non-admin visitors
//      who have NOT yet submitted (no cookie). Admins — and anyone who has
//      already submitted or is on another page — skip the popup and get the
//      `show--body` body class that reveals the page (kept hidden by theme CSS
//      until then).
//   Pairs with the ELEMENTOR POPUP LOCK block above, which makes #7822
//   non-dismissible on the same page.
// =============================================
add_action( 'wp_footer', function () {
    ?>
    <script>
    jQuery(document).ready(function () {
        get_started_form();
    });

    jQuery(window).on('load', function () {
        // Admins: never gate — just reveal the page.
        if (jQuery('body').hasClass('admin-bar')) {
            jQuery('body').addClass('show--body');
            return;
        }

        var alreadySubmitted = getCookie('get_started_form_submitted') !== undefined;

        if (!alreadySubmitted && jQuery('body').hasClass('page-id-6565')) {
            // Not yet converted, on the gated page → force the popup open.
            if (typeof elementorProFrontend !== 'undefined') {
                elementorProFrontend.modules.popup.showPopup({ id: 7822 });
            }
        } else {
            // Already converted, or any other page → reveal the page content.
            jQuery('body').addClass('show--body');
        }
    });

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function get_started_form() {
        // Already recorded a submission — no need to bind the listener again.
        if (getCookie('get_started_form_submitted') !== undefined) {
            return;
        }

        jQuery(document).on('submit_success', function (event, response) {
            // Only react to the specific "get started" form.
            if (event.target.id !== 'get_started_form') {
                return;
            }

            var myDate = new Date();
            // Expire in 30 days (30 * 24h * 60m * 60s * 1000ms).
            myDate.setTime(myDate.getTime() + (30 * 24 * 60 * 60 * 1000));

            document.cookie = 'get_started_form_submitted=true'
                + ';expires=' + myDate.toUTCString()
                + ';path=/;SameSite=Lax';
        });
    }
    </script>
    <?php
}, 10 );


// =============================================
// GET STARTED POPUP (#7822) — POPULATE & PREFILL THE QUALIFICATION FORM
//   When Elementor popup #7822 opens, fill its two <select> fields from live
//   data:
//     - #form-field-qualification_of_interest  ← `qualifications` posts
//     - #form-field-qualification_category     ← `qualification-category` terms
//   On a single qualification page the fields are pre-selected from that post
//   (title, its category, and ACF `qualification_type` / `qualification_level`).
//   The selects are upgraded to searchable Select2, and choosing a category
//   filters the qualification list (each option carries its category names so
//   the filtering is client-side).
//
//   Companion to the GET STARTED FORM gate (auto-opens #7822 on page-id-6565)
//   and the ELEMENTOR POPUP LOCK (makes #7822 non-dismissible). Requires Select2
//   to be enqueued by the theme/Elementor. Titles/term names are emitted with
//   wp_json_encode( ... JSON_HEX_* ) so they can't break out of the inline
//   <script>; the ACF get_field() calls are guarded with function_exists().
// =============================================
add_action( 'wp_footer', function () {

    // 1. Qualifications (posts) + each post's category names (for client-side filtering).
    $posts = get_posts([
        'post_type'      => 'qualifications',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $options_data = [];
    foreach ( $posts as $p ) {
        $terms = get_the_terms( $p->ID, 'qualification-category' );

        $cat_names = [];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $t ) {
                $cat_names[] = $t->name;
            }
        }

        $options_data[] = [
            'value'      => $p->post_title,
            'label'      => $p->post_title,
            'categories' => $cat_names,
        ];
    }

    // 2. Categories (qualification-category taxonomy).
    $terms = get_terms([
        'taxonomy'   => 'qualification-category',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    $category_data = [];
    if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $category_data[] = [
                'value' => $term->name,
                'label' => $term->name,
            ];
        }
    }

    // 3. Current-page context (used to pre-select the fields on a single qualification).
    $current_page_title  = '';
    $qualification_type  = '';
    $qualification_level = '';
    $current_category    = '';

    if ( is_singular( 'qualifications' ) ) {
        $post_id            = get_the_ID();
        $current_page_title = get_the_title();

        // get_field() is provided by ACF; guard so the front end doesn't fatal if ACF is inactive.
        if ( function_exists( 'get_field' ) ) {
            $qualification_type  = get_field( 'qualification_type', $post_id );
            $qualification_level = get_field( 'qualification_level', $post_id );
        }

        $post_terms = get_the_terms( $post_id, 'qualification-category' );
        if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
            $current_category = $post_terms[0]->name;
        }
    }

    // Hex flags stop titles/term names from breaking out of the inline <script>.
    $json_flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    ?>
    <script>
    jQuery( document ).on( 'elementor/popup/show', function( event, id, instance ) {
        if ( id !== 7822 ) return;

        // Elementor prefixes form field ids with 'form-field-'.
        var $selectQual = jQuery( '#form-field-qualification_of_interest' );
        var $selectCat  = jQuery( '#form-field-qualification_category' );

        // Lock the qualification field until a category is chosen. Select2 4.x
        // reflects the native `disabled` prop, so toggling it is enough. On a
        // single qualification page a category is pre-selected below, which
        // leaves the field enabled.
        function syncQualEnabled() {
            $selectQual.prop( 'disabled', ! $selectCat.val() );
        }

        var qualOptions = <?php echo wp_json_encode( $options_data, $json_flags ); ?>;
        var catOptions  = <?php echo wp_json_encode( $category_data, $json_flags ); ?>;

        var curTitle = <?php echo wp_json_encode( $current_page_title, $json_flags ); ?>;
        var curCat   = <?php echo wp_json_encode( $current_category, $json_flags ); ?>;
        var curType  = <?php echo wp_json_encode( $qualification_type, $json_flags ); ?>;
        var curLevel = <?php echo wp_json_encode( $qualification_level, $json_flags ); ?>;

        // Populate Qualifications (only once).
        if ( $selectQual.length > 0 && $selectQual.find('option').length <= 1 ) {
            jQuery.each( qualOptions, function( i, item ) {
                $selectQual.append( jQuery('<option>', { value: item.value, text: item.label }) );
            });
        }

        // Populate Categories (only once).
        if ( $selectCat.length > 0 && $selectCat.find('option').length <= 1 ) {
            jQuery.each( catOptions, function( i, item ) {
                $selectCat.append( jQuery('<option>', { value: item.value, text: item.label }) );
            });
        }

        // Pre-select from the current page's context.
        if ( curTitle ) { $selectQual.val( curTitle ); }
        if ( curCat )   { $selectCat.val( curCat ); }
        if ( curType )  { jQuery('#form-field-qualification_type').val( curType ); }
        if ( curLevel ) { jQuery('#form-field-qualification_level').val( curLevel ); }

        // Upgrade to searchable Select2 (drop the theme's nice-select first).
        setTimeout(function() {
            $selectQual.next('.nice-select').remove();
            $selectCat.next('.nice-select').remove();

            jQuery('#form-field-qualification_of_interest, #form-field-qualification_category').select2({
                placeholder: "Select an option...",
                allowClear: true,
                width: '100%',
                dropdownParent: jQuery('#elementor-popup-modal-7822')
            });

            // Apply the initial lock state once Select2 is ready.
            syncQualEnabled();
        }, 100);

        // Dependent filtering: choosing a category narrows the qualification list.
        // Namespaced + .off() first so re-opening the popup can't stack duplicate handlers.
        $selectCat.off('change.qualfilter').on('change.qualfilter', function() {
            var selectedCategory = jQuery(this).val();

            $selectQual.empty().append('<option value=""></option>');

            jQuery.each(qualOptions, function(i, item) {
                if ( selectedCategory === "" || ( item.categories && item.categories.includes(selectedCategory) ) ) {
                    $selectQual.append( jQuery('<option>', { value: item.value, text: item.label }) );
                }
            });

            $selectQual.trigger('change.select2');

            // Re-lock when the category is cleared; unlock once one is chosen.
            syncQualEnabled();
        });
    });
    </script>
    <?php
}, 10 );