<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Field_Types_Taxonomy_Select_Hierarchy
 *
 * @access public
 * @package Inventor/Classes/Field_Types
 * @return void
 */
class Inventor_Field_Types_Taxonomy_Select_Hierarchy {
    /**
     * Initialize the plugin by hooking into CMB2
     */
    public function __construct() {
        add_filter( 'cmb2_render_taxonomy_select_hierarchy', array( $this, 'render' ), 10, 5 );
        add_filter( 'cmb2_sanitize_taxonomy_select_hierarchy', array( $this, 'sanitize' ), 10, 5 );
    }

    /**
     * Render field
     *
     * @access public
     * @param $field
     * @param $field_escaped_value
     * @param $field_object_id
     * @param $field_object_type
     * @param $field_type_object
     * @return string
     */
    public function render( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
        $names       = $field_type_object->get_object_terms();
        $saved_terms = is_wp_error( $names ) || empty( $names )
            ? $field_type_object->field->args( 'default' )
            : wp_list_pluck( $names, 'slug' );
        $terms       = get_terms( $field_type_object->field->args( 'taxonomy' ), array(
            'hide_empty'    => false,
            'parent'        => 0,
        ) );
        $name        = $field_type_object->_name();
        $options     = '';

        if ( ! $terms ) {
            $options .= sprintf( '<li><label>%s</label></li>', esc_html($field_type_object->_text( 'no_terms_text', __( 'No terms', 'inventor' ) ) ) );
        } else {
            foreach ( $terms as $term ) {
                $children = $this->build_children( $field_type_object, $term, $saved_terms );

                $args = array(
                    'value' => $term->slug,
                    'label' => $term->name,
                    'name' => $name,
                );

                if ( empty( $children ) && is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
                    $args['checked'] = 'checked';
                }

                $options .= $field_type_object->select_option( $args );

                if ( ! empty( $children ) ) {
                    $options .= $children;
                }
            }
        }

        echo $field_type_object->select( array(
            'class'   => 'cmb2_select cmb2-taxonomy-select-hieararchy',
            'options' => $options,
        ) );
    }

    /**
     * Save proper values
     *
     * @access public
     * @param $override_value
     * @param $value
     * @param $object_id
     * @param $field_args
     * @return void
     */
    public function sanitize( $override_value, $value, $object_id, $field_args ) {
        $value_to_set = array( $value );

        $taxonomy = $field_args['taxonomy'];
        $term = get_term_by( 'slug', $value, $taxonomy );
        $parents = get_ancestors( $term->term_id, $taxonomy );

        foreach ( $parents as $parent ) {
            $parent_term = get_term( $parent, $taxonomy );
            $slug = $parent_term->slug;
            $value_to_set[] = $slug;
        }

        wp_set_object_terms( $object_id, $value_to_set, $taxonomy );
    }

    /**
     * Build children hierarchy
     *
     * @access public
     * @param $object
     * @param $parent_term
     * @param $saved_terms
     * @return null|string
     */
    public function build_children( $object, $parent_term, $saved_terms, $depth = 1 ) {
        $output = null;

        $terms = get_terms( $object->field->args( 'taxonomy' ), array(
            'hide_empty'    => false,
            'parent'        => $parent_term->term_id,
        ) );

        if ( ! empty( $terms ) && is_array( $terms ) ) {
            $output = '';

            foreach( $terms as $term ) {
                $args = array(
                    'value' => $term->slug,
                    'label' => str_repeat("-", $depth) . ' ' . $term->name,
                    'type' => 'checkbox',
                );

                if ( is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
                    $args['checked'] = 'checked';
                }

                $output .= $object->select_option( $args );
                $children = $this->build_children( $object, $term, $saved_terms, $depth + 1 );

                if ( ! empty( $children ) ) {
                    $output .= $children;
                }
            }
        }

        return $output;
    }
}

new Inventor_Field_Types_Taxonomy_Select_Hierarchy();