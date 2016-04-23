<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Post_Type_Listing.
     * @class  Inventor_Post_Type_Listing
     * @author Pragmatic Mates
     */
    class Inventor_Post_Type_Listing
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('init', [__CLASS__, 'process_inquire_form'], 9999);
            add_action('pre_get_posts', [__CLASS__, 'show_all_listings']);
        }

        /**
         * @param $post_id int
         */
        public static function get_inventor_poi($post_id = null)
        {
            if (null === $post_id) {
                $post_id = get_the_ID();
            }
            $categories = wp_get_post_terms($post_id, 'listing_categories', [
                'orderby' => 'parent',
                'order'   => 'ASC',
            ]);
            $categories_count = count($categories);
            if (is_array($categories) && $categories_count > 0) {
                $category = array_shift($categories);

                return Taxonomy_MetaData::get('listing_categories', $category->term_id, 'poi');
            }

            return;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Listings', 'inventor'),
                'singular_name'      => __('Listing', 'inventor'),
                'add_new'            => __('Add New Listing', 'inventor'),
                'add_new_item'       => __('Add New Listing', 'inventor'),
                'edit_item'          => __('Edit Listing', 'inventor'),
                'new_item'           => __('New Listing', 'inventor'),
                'all_items'          => __('Listings', 'inventor'),
                'view_item'          => __('View Listing', 'inventor'),
                'search_items'       => __('Search Listing', 'inventor'),
                'not_found'          => __('No Listings found', 'inventor'),
                'not_found_in_trash' => __('No Listings Found in Trash', 'inventor'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Listing', 'inventor'),
            ];
            register_post_type('listing', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('listings', 'URL slug', 'inventor')],
                'public'       => true,
                'show_ui'      => false,
                'categories'   => [],
            ]);
        }

        /**
         * Display all listings.
         *
         * @param $query
         *
         * @return mixed
         */
        public static function show_all_listings($query)
        {
            if (is_post_type_archive('listing') && $query->is_main_query() && ! is_admin() && 'listing' === $query->query_vars['post_type']) {
                $query->set('post_type', Inventor_Post_Types::get_listing_post_types(true));

                return $query;
            }

            return;
        }

        /**
         * Process enquire form.
         */
        public static function process_inquire_form()
        {
            if ( ! isset($_POST['inquire_form']) || empty($_POST['post_id'])) {
                return;
            }
            $post  = get_post($_POST['post_id']);
            $email = esc_html($_POST['email']);
            $phone = esc_html($_POST['phone']);
            $name  = esc_html($_POST['name']);
            $date  = esc_html($_POST['date']);
            if ( ! empty($_POST['subject'])) {
                $subject = $_POST['subject'];
            } else {
                $subject = __('Message from enquire form', 'inventor');
            }
            $headers = sprintf("From: %s <%s>\r\n Content-type: text/html", $name, $email);
            ob_start();
            include Inventor_Template_Loader::locate('mails/inquire');
            $message = ob_get_contents();
            ob_end_clean();
            $emails = [];
            // Author
            if ( ! empty($_POST['receive_author'])) {
                $emails[] = get_the_author_meta('user_email', $post->post_author);
            }
            // Admin
            if ( ! empty($_POST['receive_admin'])) {
                $emails[] = get_bloginfo('admin_email');
            }
            // Listing email
            if ( ! empty($_POST['receive_listing_email'])) {
                $email = get_post_meta($_POST['post_id'], INVENTOR_LISTING_PREFIX . 'email', true);
                if ( ! empty($email)) {
                    $emails[] = $email;
                }
            }
            // Default fallback
            if (empty($_POST['receive_admin']) && empty($_POST['receive_author'])) {
                $emails[] = get_the_author_meta('user_email', $post->post_author);
            }
            $emails = array_unique($emails);
            foreach ($emails as $email) {
                $status = wp_mail($email, $subject, $message, $headers);
            }
            $success = ! empty($status) && 1 === $status;
            do_action('inventor_inquire_message_sent', $success, $_POST['post_id'], $_POST['name'], $_POST['email'],
                $_POST['subject'], $_POST['date'], $_POST['message'], ! empty($_POST['receive_author']),
                ! empty($_POST['receive_admin']), ! empty($_POST['receive_listing_email']));
            if ($success) {
                $_SESSION['messages'][] = ['success', __('Message has been successfully sent.', 'inventor')];
            } else {
                $_SESSION['messages'][] = ['danger', __('Unable to send a message.', 'inventor')];
            }
            // redirect to post
            $url = get_permalink($_POST['post_id']);
            wp_redirect($url);
            die();
        }
    }

    Inventor_Post_Type_Listing::init();
