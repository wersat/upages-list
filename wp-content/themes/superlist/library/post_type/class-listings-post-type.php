<?php
    /**
     * Created by PhpStorm.
     * User: jazzman
     * Date: 21.04.16
     * Time: 5:02
     */
    namespace Upages_Post_Type;

    use Upages_Objects\Custom_Post_Type;

    /**
     * Class Listings_Post_Type
     *
     * @package Upages_Post_Type
     */
class Listings_Post_Type
{
    /**
         * @type
         */
    public $post_type;
    /**
         * @type string
         */
    public $post_type_name = 'Listing New';

    /**
         * @type string
         */
    public $post_type_prefix;
    /**
         * @type string
         */
    public $post_type_slug;
    /**
         * @type array
         */
    public $post_type_option
    = [
        'show_in_menu' => 'listings',
        'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
        'has_archive'  => true,
        'public'       => true,
        'show_ui'      => true,
    ];

    /**
         * Listings_Post_Type constructor.
         */
    public function __construct()
    {
        $this->post_type_slug   = sanitize_title($this->post_type_name);
        $this->post_type_prefix = sanitize_title($this->post_type_name) . '_';
        $this->setPostType();
        add_action('init', [$this, 'process_inquire_form'], 9999);
        add_action('pre_get_posts', [$this, 'show_all_listings']);
    }

    /**
         *
         */
    public function setPostType()
    {
        $this->post_type = new Custom_Post_Type(
            [
            'post_type_name' => $this->post_type_slug,
            'singular'       => $this->post_type_name,
            'plural'         => $this->post_type_name,
            'slug'           => $this->post_type_slug
            ], $this->post_type_option
        );
    }

    /**
         * @param $query
         */
    public function show_all_listings($query)
    {
        if (is_post_type_archive($this->post_type_slug) && $query->is_main_query() && ! is_admin() && $this->post_type_slug === $query->query_vars['post_type']) {
            $query->set('post_type', $this->get_listing_post_types(true));

            return $query;
        }

        return;
    }

    public function get_listing_post_types($include_abstract = false)
    {
        $listings_types = [];
        $post_types     = get_post_types([], 'objects');
        if (! empty($post_types)) {
            foreach ($post_types as $post_type) {
                if ($post_type->show_in_menu === 'listings') {
                    $listings_types[] = $post_type->name;
                }
            }
        }
        // Sort alphabetically
        var_dump($listings_types);
        sort($listings_types);
        if ($include_abstract) {
            array_unshift($listings_types, 'listing');
        }

        return $listings_types;
    }

    /**
         *
         */
    public function process_inquire_form()
    {
        if (! isset($_POST['inquire_form']) || empty($_POST['post_id'])) {
            return;
        }
        $post  = get_post($_POST['post_id']);
        $email = esc_html($_POST['email']);
        $phone = esc_html($_POST['phone']);
        $name  = esc_html($_POST['name']);
        $date  = esc_html($_POST['date']);
        if (! empty($_POST['subject'])) {
            $subject = $_POST['subject'];
        } else {
            $subject = __('Message from enquire form', 'inventor');
        }
        $headers = sprintf("From: %s <%s>\r\n Content-type: text/html", $name, $email);
        ob_start();
        $from = '';
        if (! empty($name)) {
            $from .= '<strong>' . __('Name', 'inventor') . ' ' . esc_attr($name) . '</strong><br><br>';
        }
        if (! empty($email)) {
            $from .= '<strong>' . __('E-mail', 'inventor') . ' ' . esc_attr($email) . '</strong><br><br>';
        }
        if (! empty($phone)) {
            $from .= '<strong>' . __('Phone', 'inventor') . ' ' . esc_attr($phone) . '</strong><br><br>';
        }
        if (! empty($date)) {
            $from .= '<strong>' . __('Date', 'inventor') . ' ' . esc_attr($date) . '</strong><br><br>';
        }
        $permalink = get_permalink($post->ID);
        if (! empty($permalink)) {
            $from .= '<strong>' . __('URL', 'inventor') . ' ' . esc_attr($permalink) . '</strong><br><br>';
        }
        if (! empty($_POST['message'])) {
            $from .= esc_html($_POST['message']);
        }
        echo $from;
        $message = ob_get_contents();
        ob_end_clean();
        $emails = [];
        // Author
        if (! empty($_POST['receive_author'])) {
            $emails[] = get_the_author_meta('user_email', $post->post_author);
        }
        // Admin
        if (! empty($_POST['receive_admin'])) {
            $emails[] = get_bloginfo('admin_email');
        }
        // Listing email
        if (! empty($_POST['receive_listing_email'])) {
            $email = get_post_meta($_POST['post_id'], INVENTOR_LISTING_PREFIX . 'email', true);
            if (! empty($email)) {
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
        do_action(
            'inventor_inquire_message_sent', $success, $_POST['post_id'], $_POST['name'], $_POST['email'],
            $_POST['subject'], $_POST['date'], $_POST['message'], ! empty($_POST['receive_author']),
            ! empty($_POST['receive_admin']), ! empty($_POST['receive_listing_email'])
        );
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
