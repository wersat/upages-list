<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Google_Map_Ajax.
     * @class  Inventor_Google_Map_Ajax
     * @author Pragmatic Mates
     */
    class Inventor_Google_Map_Ajax
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('wp_ajax_nopriv_inventor_filter_listings', [__CLASS__, 'filter']);
            add_action('wp_ajax_inventor_filter_listings', [__CLASS__, 'filter']);
            add_action('save_post', [__CLASS__, 'invalidate_cache']);
        }

        /**
         * Remove all cached AJAX responses.
         */
        public static function invalidate_cache()
        {
            global $wpdb;
            $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'inventor_google_map_ajax_%'");
        }

        /**
         * Filter all listings through AJAX.
         * @return string
         */
        public static function filter()
        {
            header('HTTP/1.0 200 OK');
            header('Content-Type: application/json');
            $uri   = md5($_SERVER['REQUEST_URI']);
            $cache = get_option("inventor_google_map_ajax_{$uri}", 0);
            if ($cache) {
                echo $cache;
                exit();
            }
            $property_groups = [];
            $data            = [];
            $post_types      = Inventor_Post_Types::get_listing_post_types();
            // Post type
            if ( ! empty($_GET['post-type'])) {
                $post_types = $_GET['post-type'];
            }
            $args = [
                'post_type'      => $post_types,
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ];
            // Term
            if ( ! empty($_GET['term']) && ! empty($_GET['term-taxonomy'])) {
                $_GET['filter-' . $_GET['term-taxonomy']] = $_GET['term'];
            }
            // Order by
            if ( ! empty($_GET['orderby'])) {
                if ($_GET['orderby'] == 'rand') {
                    $args['orderby'] = 'rand';
                }
            }
            query_posts($args);
            Inventor_Query::loop_listings_filter($_GET);
            if (have_posts()) {
                $index = 0;
                if ( ! empty($_GET['max-pins'])) {
                    $max_pins = $_GET['max-pins'];
                }
                while (have_posts() && (empty($max_pins) || ( ! empty($max_pins) && $index < $max_pins))) {
                    the_post();
                    // Property GPS positions. We will use these values
                    // for genearating unique md5 hash for property groups.
                    $latitude  = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude', true);
                    $longitude = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_longitude', true);
                    // Build on array of property groups. We need to know how
                    // many and which properties are at the same position.
                    if ( ! empty($latitude) && ! empty($longitude)) {
                        $hash                     = sha1($latitude . $longitude);
                        $property_groups[$hash][] = get_the_ID();
                        ++$index;
                    }
                }
            }
            wp_reset_query();
            foreach ($property_groups as $group) {
                $args = [
                    'post_type'      => Inventor_Post_Types::get_listing_post_types(),
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'post__in'       => $group,
                ];
                query_posts($args);
                if (have_posts()) {
                    // Group of properties at the same position so we will process
                    // property loop inside the template.
                    if (count($group) > 1) {
                        $latitude  = get_post_meta($group[0], INVENTOR_LISTING_PREFIX . 'map_location_latitude', true);
                        $longitude = get_post_meta($group[0], INVENTOR_LISTING_PREFIX . 'map_location_longitude', true);
                        // Marker
                        ob_start();
                        $template = Inventor_Template_Loader::locate('google-map/infowindow-group',
                            INVENTOR_GOOGLE_MAP_DIR);
                        include $template;
                        $output = ob_get_contents();
                        ob_end_clean();
                        $content = str_replace(["\r\n", "\n", "\t"], '', $output);
                        // Infowindow
                        ob_start();
                        $template = Inventor_Template_Loader::locate('google-map/marker-group',
                            INVENTOR_GOOGLE_MAP_DIR);
                        include $template;
                        $output = ob_get_contents();
                        ob_end_clean();
                        $marker_content = str_replace(["\r\n", "\n", "\t"], '', $output);
                        // Just one property. We can get current post here.
                    } else {
                        the_post();
                        $latitude       = get_post_meta(get_the_ID(), INVENTOR_LISTING_PREFIX . 'map_location_latitude',
                            true);
                        $longitude      = get_post_meta(get_the_ID(),
                            INVENTOR_LISTING_PREFIX . 'map_location_longitude', true);
                        $content        = str_replace(["\r\n", "\n", "\t"], '',
                            Inventor_Template_Loader::load('google-map/infowindow', [], INVENTOR_GOOGLE_MAP_DIR));
                        $marker_content = str_replace(["\r\n", "\n", "\t"], '',
                            Inventor_Template_Loader::load('google-map/marker', [], INVENTOR_GOOGLE_MAP_DIR));
                    }
                    // Array of values passed into markers[] array in jquery-google-map.js library
                    $data[] = [
                        'latitude'       => $latitude,
                        'longitude'      => $longitude,
                        'content'        => $content,
                        'marker_content' => $marker_content,
                    ];
                }
                wp_reset_query();
            }
            $data = json_encode($data);
            update_option("inventor_google_map_ajax_{$uri}", $data);
            echo $data;
            exit();
        }
    }

    Inventor_Google_Map_Ajax::init();
