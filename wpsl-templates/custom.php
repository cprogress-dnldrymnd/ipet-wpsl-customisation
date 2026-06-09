<?php
/**
 * Custom WPSL search form template — bundled with the iPet WPSL Customisation plugin
 * and registered via the `wpsl_templates` filter. WPSL includes this file in the
 * context of its frontend class, so `$this` refers to that class instance.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $wpsl_settings, $wpsl;

$output         = $this->get_custom_css();
$autoload_class = (!$wpsl_settings['autoload']) ? 'class="wpsl-not-loaded"' : '';

$output .= '<div id="wpsl-wrap">' . "\r\n";
$output .= "\t" . '<div class="wpsl-search wpsl-clearfix ' . $this->get_css_classes() . '">' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-search-wrap">' . "\r\n";
$output .= "\t\t\t" . '<form autocomplete="off" class="row">' . "\r\n";
$output .= "\t\t\t" . '<div class="col-lg-4">' . "\r\n";
$output .= "\t\t\t" . '<div class="wpsl-input">' . "\r\n";
#$output .= "\t\t\t\t" . '<div><label for="wpsl-search-input">' . esc_html($wpsl->i18n->get_translation('search_label', __('Your location', 'wpsl'))) . '</label></div>' . "\r\n";
$output .= "\t\t\t\t" . '<input id="wpsl-search-input" type="text" value="' . apply_filters('wpsl_search_input', '') . '" name="wpsl-search-input" placeholder="Enter city or Postcode" aria-required="true" />' . "\r\n";
$output .= "\t\t\t" . '</div>' . "\r\n";
$output .= "\t\t\t" . '</div>' . "\r\n";

if ($wpsl_settings['radius_dropdown'] || $wpsl_settings['results_dropdown']) {
    $output .= "\t\t\t" . '<div class="col-lg-4">' . "\r\n";
    $output .= "\t\t\t" . '<div class="wpsl-select-wrap">' . "\r\n";

    if ($wpsl_settings['radius_dropdown']) {
        $output .= "\t\t\t\t" . '<div id="wpsl-radius">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-radius-dropdown">' . esc_html($wpsl->i18n->get_translation('radius_label', __('Search radius', 'wpsl'))) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-radius-dropdown" class="" name="wpsl-radius">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list('search_radius') . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    }

    if ($wpsl_settings['results_dropdown']) {
        $output .= "\t\t\t\t" . '<div id="wpsl-results">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-results-dropdown">' . esc_html($wpsl->i18n->get_translation('results_label', __('Results', 'wpsl'))) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-results-dropdown" class="wpsl-dropdown" name="wpsl-results">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list('max_results') . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    }

    $output .= "\t\t\t" . '</div>' . "\r\n";
    $output .= "\t\t\t" . '</div>' . "\r\n";
}

if ($this->use_category_filter()) {
    $output .= $this->create_category_filter();
}

$qualification_of_interest = isset($_GET['qualification_of_interest']) ? $_GET['qualification_of_interest'] : '';
$qualification_level = isset($_GET['qualification_level']) ? $_GET['qualification_level'] : '';
$qualification_type = isset($_GET['qualification_type']) ? $_GET['qualification_type'] : '';

/**Qualification Type*/
$types = get_terms(
    array(
        'taxonomy' => 'wpsl_store_category',
        'hide_empty' => true,
        'parent' => 246
    )
);
$output .= '<div class="wpsl-input--custom-category col-lg-4">
    <select name="qualification-type" id="qualification-type" class="wpsl-custom-dropdown">';
$output .= '<option value="">Qualification Type</option>';

if (! empty($types) && ! is_wp_error($types)) {

    foreach ($types as $type) {
		if($type->name == $qualification_type) {
			$selected = 'selected="selected';
		} else {
			$selected = '';
		}
        $output .= '<option '.$selected.' value="' . esc_attr($type->term_id) . '">' . esc_html($type->name) . '</option>';
    }
}
$output .= '</select>
</div>';
/**End of Qualification Type*/

/**Qualification Interest*/
$Interests = get_terms(
    array(
        'taxonomy' => 'wpsl_store_category',
        'hide_empty' => true,
        'parent' => 249
    )
);



$output .= '<div class="wpsl-input--custom-category col-lg-4">

    <select name="qualification_of_interest" id="qualification_of_interest" class="wpsl-custom-dropdown">';
$output .= '<option value="">Qualification of Interest</option>';
if (! empty($Interests) && ! is_wp_error($Interests)) {

    foreach ($Interests as $Interest) {
		if($Interest->name == $qualification_of_interest) {
			$selected = 'selected="selected';
		} else {
			$selected = '';
		}
        $output .= '<option '.$selected.' value="' . esc_attr($Interest->term_id) . '">' . esc_html($Interest->name) . '</option>';
    }
}
$output .= '</select>
</div>';
/**End of Qualification Interest*/

/**Qualification Level*/
$Levels = get_terms(
    array(
        'taxonomy' => 'wpsl_store_category',
        'hide_empty' => false,
        'parent' => 250
    )
);
$output .= '<div class="wpsl-input--custom-category col-lg-4">
    <select name="qualification_level" id="qualification_level" class="wpsl-custom-dropdown">';
$output .= '<option value="">Qualification Level</option>';

if (! empty($Levels) && ! is_wp_error($Levels)) {

    foreach ($Levels as $Level) {
		if($Level->name == $qualification_level) {
			$selected = 'selected="selected';
		} else {
			$selected = '';
		}
        $output .= '<option '.$selected.' value="' . esc_attr($Level->term_id) . '">' . esc_html($Level->name) . '</option>';
    }
}
$output .= '</select>
</div>';
/**End of Qualification Level*/

$output .= "\t\t\t\t" . '<div class="col-lg-4"><div class="wpsl-search-btn-wrap"><input id="wpsl-search-btn" type="submit" value="' . esc_attr($wpsl->i18n->get_translation('search_btn_label', __('Search', 'wpsl'))) . '"></div></div>' . "\r\n";

$output .= "\t\t" . '</form>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";

$output .= "\t" . '<div class="row">' . "\r\n";


$output .= "\t" . '<div class="col-lg-6">' . "\r\n";
$output .= "\t" . '<div id="wpsl-result-list">' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-stores" ' . $autoload_class . '>' . "\r\n";
$output .= "\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-direction-details">' . "\r\n";
$output .= "\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";

$output .= "\t" . '<div class="col-lg-6">' . "\r\n";
$output .= "\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";




$output .= "\t" . '</div>' . "\r\n";


if ($wpsl_settings['show_credits']) {
    $output .= "\t" . '<div class="wpsl-provided-by">' . sprintf(__("Search provided by %sWP Store Locator%s", "wpsl"), "<a target='_blank' href='https://wpstorelocator.co'>", "</a>") . '</div>' . "\r\n";
}

$output .= '</div>' . "\r\n";

return $output;
