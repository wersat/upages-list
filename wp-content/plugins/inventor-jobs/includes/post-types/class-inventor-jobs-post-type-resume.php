<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Jobs_Post_Type_Resume.
     * @class  Inventor_Jobs_Post_Type_Resume
     * @author Pragmatic Mates
     */
    class Inventor_Jobs_Post_Type_Resume
    {
        /**
         * Initialize custom post type.
         */
        public static function init()
        {
            add_action('init', [__CLASS__, 'definition']);
            add_action('cmb2_init', [__CLASS__, 'fields']);
            add_filter('inventor_claims_allowed_listing_post_types', [__CLASS__, 'allowed_claiming']);
            add_filter('inventor_metabox_location_polygon_enabled', [__CLASS__, 'disable_some_metabox_location_fields'],
                10, 2);
            add_filter('inventor_metabox_location_street_view_enabled',
                [__CLASS__, 'disable_some_metabox_location_fields'], 10, 2);
            add_filter('inventor_metabox_location_inside_view_enabled',
                [__CLASS__, 'disable_some_metabox_location_fields'], 10, 2);
        }

        /**
         * Defines if post type can be claimed.
         *
         * @param array $post_types
         *
         * @return array
         */
        public static function allowed_claiming($post_types)
        {
            $post_types[] = 'resume';

            return $post_types;
        }

        /**
         * Custom post type definition.
         */
        public static function definition()
        {
            $labels = [
                'name'               => __('Resumes', 'inventor-jobs'),
                'singular_name'      => __('Resume', 'inventor-jobs'),
                'add_new'            => __('Add New Resume', 'inventor-jobs'),
                'add_new_item'       => __('Add New Resume', 'inventor-jobs'),
                'edit_item'          => __('Edit Resume', 'inventor-jobs'),
                'new_item'           => __('New Resume', 'inventor-jobs'),
                'all_items'          => __('Resumes', 'inventor-jobs'),
                'view_item'          => __('View Resume', 'inventor-jobs'),
                'search_items'       => __('Search Resume', 'inventor-jobs'),
                'not_found'          => __('No Resumes found', 'inventor-jobs'),
                'not_found_in_trash' => __('No Resumes Found in Trash', 'inventor-jobs'),
                'parent_item_colon'  => '',
                'menu_name'          => __('Resumes', 'inventor-jobs'),
            ];
            register_post_type('resume', [
                'labels'       => $labels,
                'show_in_menu' => 'listings',
                'supports'     => ['title', 'editor', 'thumbnail', 'comments', 'author'],
                'has_archive'  => true,
                'rewrite'      => ['slug' => _x('resumes', 'URL slug', 'inventor-jobs')],
                'public'       => true,
                'show_ui'      => true,
                'categories'   => [],
            ]);
        }

        /**
         * Defines custom fields.
         * @return array
         */
        public static function fields()
        {
            Inventor_Post_Types::add_metabox('resume', ['general']);
            // Details
            $details = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'resume_details',
                'title'        => __('Details', 'inventor-jobs'),
                'object_types' => ['resume'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            // Working history
            $working_history_box = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'resume_working_history',
                'title'        => __('Working history', 'inventor-jobs'),
                'object_types' => ['resume'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $working_history     = $working_history_box->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'resume_working_history_group',
                'type'    => 'group',
                'options' => [
                    'group_title'   => __('Item', 'inventor-jobs'),
                    'add_button'    => __('Add Another', 'inventor-jobs'),
                    'remove_button' => __('Remove', 'inventor-jobs'),
                ],
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . 'resume_working_history',
                    INVENTOR_LISTING_PREFIX . 'resume_working_history_group'),
            ]);
            $working_history_box->add_group_field($working_history, [
                'id'         => INVENTOR_LISTING_PREFIX . 'resume_working_history_title',
                'name'       => __('Title', 'inventor-jobs'),
                'type'       => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
            ]);
            $working_history_box->add_group_field($working_history, [
                'id'   => INVENTOR_LISTING_PREFIX . 'resume_working_history_description',
                'name' => __('Description', 'inventor-jobs'),
                'type' => 'textarea',
            ]);
            $working_history_box->add_group_field($working_history, [
                'id'   => INVENTOR_LISTING_PREFIX . 'resume_working_history_date_from',
                'name' => __('Date from', 'inventor-jobs'),
                'type' => 'text_date_timestamp',
            ]);
            $working_history_box->add_group_field($working_history, [
                'id'   => INVENTOR_LISTING_PREFIX . 'resume_working_history_date_to',
                'name' => __('Date to', 'inventor-jobs'),
                'type' => 'text_date_timestamp',
            ]);
            // Experience
            $experience_box = new_cmb2_box([
                'id'           => INVENTOR_LISTING_PREFIX . 'resume_experience',
                'title'        => __('Experience', 'inventor-jobs'),
                'object_types' => ['resume'],
                'context'      => 'normal',
                'priority'     => 'high',
            ]);
            $experience     = $experience_box->add_field([
                'id'      => INVENTOR_LISTING_PREFIX . 'resume_experience_group',
                'type'    => 'group',
                'options' => [
                    'group_title'   => __('Item', 'inventor-jobs'),
                    'add_button'    => __('Add Another', 'inventor-jobs'),
                    'remove_button' => __('Remove', 'inventor-jobs'),
                ],
                'default' => Inventor_Submission::get_submission_field_value(INVENTOR_LISTING_PREFIX . 'resume_experience',
                    INVENTOR_LISTING_PREFIX . 'resume_experience_group'),
            ]);
            $experience_box->add_group_field($experience, [
                'id'         => INVENTOR_LISTING_PREFIX . 'resume_experience_title',
                'name'       => __('Title', 'inventor-jobs'),
                'type'       => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
            ]);
            $experience_box->add_group_field($experience, [
                'id'   => INVENTOR_LISTING_PREFIX . 'resume_experience_since',
                'name' => __('Since', 'inventor-jobs'),
                'type' => 'text_date_timestamp',
            ]);
            $experience_levels = [
                'beginner'     => __('Beginner', 'inventor-jobs'),
                'intermediate' => __('Intermediate', 'inventor-jobs'),
                'professional' => __('Professional', 'inventor-jobs'),
            ];
            $experience_box->add_group_field($experience, [
                'id'      => INVENTOR_LISTING_PREFIX . 'resume_experience_level',
                'name'    => __('Level', 'inventor-jobs'),
                'type'    => 'radio',
                'options' => apply_filters('inventor_jobs_experience_levels', $experience_levels),
            ]);
            Inventor_Post_Types::add_metabox('resume', ['contact', 'location', 'social']);
        }

        /**
         * Disable some location fields for resume post type.
         *
         * @param bool   $enabled
         * @param string $post_type
         *
         * @return bool
         */
        public static function disable_some_metabox_location_fields($enabled, $post_type)
        {
            return $post_type == 'resume' ? false : $enabled;
        }
    }

    Inventor_Jobs_Post_Type_Resume::init();
