<?php
/*
Plugin Name: London Map Plugin
Description: Displays a map of London with locations (e.g., dog-friendly baby toilets) using Google Maps. Supports shortcode and Gutenberg block.
Version: 1.0.0
Author: Your Name

// IMPORTANT: Replace 'YOUR_GOOGLE_MAPS_API_KEY' in the plugin with your actual Google Maps API key.
*/

if (!defined('ABSPATH')) exit;

class LondonMapPlugin {
    public function __construct() {
        add_action('init', [$this, 'register_location_cpt']);
        add_action('add_meta_boxes', [$this, 'add_location_meta_boxes']);
        add_action('save_post', [$this, 'save_location_meta'], 10, 2);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_shortcode('london_map', [$this, 'render_map_shortcode']);
        add_action('init', [$this, 'register_gutenberg_block']);
    }

    public function register_location_cpt() {
        register_post_type('lmp_location', [
            'labels' => [
                'name' => 'Locations',
                'singular_name' => 'Location',
            ],
            'public' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'custom-fields'],
        ]);
    }

    public function add_location_meta_boxes() {
        add_meta_box('lmp_location_details', 'Location Details', [$this, 'render_location_meta_box'], 'lmp_location', 'normal', 'default');
    }

    public function render_location_meta_box($post) {
        $fields = [
            'google_place_id' => 'Google Place ID',
            'address' => 'Address',
            'lat' => 'Latitude',
            'lng' => 'Longitude',
            'type' => 'Type (e.g., train station, park, etc.)',
            'accessible' => 'Accessible (yes/no)',
            'toilets' => 'Toilets (yes/no)',
            'baby_changing' => 'Baby Changing (yes/no)',
            'opening_hours' => 'Opening Hours',
            'show_on_map' => 'Show on Map (yes/no)',
            'notes' => 'Admin Notes',
            'tags' => 'Tags (comma separated)',
        ];
        foreach ($fields as $key => $label) {
            $value = esc_attr(get_post_meta($post->ID, $key, true));
            echo '<p><label for="' . $key . '">' . $label . '</label><br />';
            if ($key === 'notes' || $key === 'opening_hours' || $key === 'address') {
                echo '<textarea name="' . $key . '" id="' . $key . '" rows="2" style="width:100%">' . $value . '</textarea>';
            } else {
                echo '<input type="text" name="' . $key . '" id="' . $key . '" value="' . $value . '" style="width:100%" />';
            }
            echo '</p>';
        }
    }

    public function save_location_meta($post_id, $post) {
        if ($post->post_type !== 'lmp_location') return;
        $fields = [
            'google_place_id', 'address', 'lat', 'lng', 'type', 'accessible', 'toilets', 'baby_changing', 'opening_hours', 'show_on_map', 'notes', 'tags'
        ];
        foreach ($fields as $key) {
            if (isset($_POST[$key])) {
                update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
            }
        }
    }

    public function enqueue_scripts() {
        if (!is_admin()) {
            wp_enqueue_script(
                'google-maps',
                'https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY',
                [],
                null,
                true
            );
            wp_enqueue_script(
                'lmp-frontend',
                plugins_url('lmp-frontend.js', __FILE__),
                ['google-maps'],
                '1.0.0',
                true
            );
            wp_localize_script('lmp-frontend', 'LMP_LOCATIONS', $this->get_locations());
        }
    }

    private function get_locations() {
        $args = [
            'post_type' => 'lmp_location',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_key' => 'show_on_map',
            'meta_value' => 'yes',
        ];
        $query = new WP_Query($args);
        $locations = [];
        foreach ($query->posts as $post) {
            $locations[] = [
                'title' => get_the_title($post),
                'description' => apply_filters('the_content', $post->post_content),
                'lat' => get_post_meta($post->ID, 'lat', true),
                'lng' => get_post_meta($post->ID, 'lng', true),
                'type' => get_post_meta($post->ID, 'type', true),
                'accessible' => get_post_meta($post->ID, 'accessible', true),
                'toilets' => get_post_meta($post->ID, 'toilets', true),
                'baby_changing' => get_post_meta($post->ID, 'baby_changing', true),
                'opening_hours' => get_post_meta($post->ID, 'opening_hours', true),
                'tags' => get_post_meta($post->ID, 'tags', true),
            ];
        }
        return $locations;
    }

    public function render_map_shortcode($atts) {
        return '<div id="lmp-map"></div>';
    }

    public function register_gutenberg_block() {
        if (!function_exists('register_block_type')) return;
        register_block_type(__DIR__ . '/block');
    }
}

new LondonMapPlugin(); 