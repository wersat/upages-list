<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Pricing_Logic
 *
 * @class Inventor_Pricing_Logic
 * @package Inventor/Classes
 * @author Pragmatic Mates
 */
class Inventor_Pricing_Logic {
    /**
     * Initialize pricing system
     *
     * @access public
     * @return void
     */
    public static function init() {
    }

    /**
     * Formats pricing price
     *
     * @param $pricing_id
     * @return string
     */
    public static function get_pricing_formatted_price( $pricing_id ) {
        $price = get_post_meta( $pricing_id, INVENTOR_PRICING_PREFIX . 'price', true );
        $price_modified = apply_filters( 'inventor_pricing_price', $price, $pricing_id );
        $price_formatted = Inventor_Price::format_price( $price );
        return $price != $price_modified ? $price_modified : $price_formatted;
    }
}

Inventor_Pricing_Logic::init();