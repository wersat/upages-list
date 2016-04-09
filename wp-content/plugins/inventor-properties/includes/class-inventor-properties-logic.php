<?php
    if ( ! defined('ABSPATH')) {
        exit;
    }

    /**
     * Class Inventor_Properties_Logic
     * @class   Inventor_Properties_Logic
     * @package Inventor/Classes
     * @property $allowed_post_types
     * @author  Pragmatic Mates
     */
    class Inventor_Properties_Logic
    {
        /**
         * Initialize property system
         * @access public
         * @return void
         */
        public static function init()
        {
            add_action('inventor_after_listing_detail_attributes', [__CLASS__, 'amenities']);
            add_action('inventor_after_listing_detail_attributes', [__CLASS__, 'valuation']);
            add_action('inventor_after_listing_detail_attributes', [__CLASS__, 'public_facilities']);
            add_filter('inventor_attribute_value', [__CLASS__, 'attribute_value'], 10, 2);
        }

        /**
         * Renders property amenities
         * @access public
         * @return void
         */
        public static function amenities()
        {
            echo Inventor_Template_Loader::load('amenities', [], INVENTOR_PROPERTIES_DIR);
        }

        /**
         * Renders property valuation
         * @access public
         * @return void
         */
        public static function valuation()
        {
            echo Inventor_Template_Loader::load('valuation', [], INVENTOR_PROPERTIES_DIR);
        }

        /**
         * Renders property public facilities
         * @access public
         * @return void
         */
        public static function public_facilities()
        {
            echo Inventor_Template_Loader::load('public-facilities', [], INVENTOR_PROPERTIES_DIR);
        }

        /**
         * Modifies home and lot area attributes
         * @access public
         *
         * @param string $value
         * @param array  $field
         *
         * @return string
         */
        public static function attribute_value($value, $field)
        {
            // Home and lot area
            $field_ids = [
                INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'home_area',
                INVENTOR_LISTING_PREFIX . INVENTOR_PROPERTY_PREFIX . 'lot_area'
            ];
            if (in_array($field['id'], $field_ids)) {
                $area_unit = get_theme_mod('inventor_measurement_area_unit', 'sqft');
                $value     = sprintf('%s %s', $value, $area_unit);
            }

            return $value;
        }
    }

    Inventor_Properties_Logic::init();
