<?php
/**
 * Class CMB2_Field_Taxonomy_Multicheck_Hierarchy
 */
class CMB2_Field_Taxonomy_Multicheck_Hierarchy {
	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_filter( 'cmb2_render_taxonomy_multicheck_hierarchy', array( $this, 'render' ), 10, 5 );
		add_filter( 'cmb2_sanitize_taxonomy_multicheck_hierarchy', array( $this, 'sanitize' ), 10, 5 );
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
		$name        = $field_type_object->_name() . '[]';
		$options     = ''; $i = 1;

		if ( ! $terms ) {
			$options .= sprintf( '<li><label>%s</label></li>', esc_html($field_type_object->_text( 'no_terms_text', __( 'No terms', 'cmb2' ) ) ) );
		} else {
			foreach ( $terms as $term ) {
				$args = array(
					'value' => $term->slug,
					'label' => $term->name,
					'type' => 'checkbox',
					'name' => $name,
				);

				if ( is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
					$args['checked'] = 'checked';
				}

				$options .= $field_type_object->list_input( $args, $i );
				$children = $this->build_children( $field_type_object, $term, $saved_terms );

				if ( ! empty( $children ) ) {
					$options .= $children;
				}

				$i++;
			}
		}
		$classes = false === $field_type_object->field->args( 'select_all_button' )
			? 'cmb2-checkbox-list no-select-all cmb2-list'
			: 'cmb2-checkbox-list cmb2-list';

		echo sprintf( '<ul class="%s">%s</ul>', $classes, $options );
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
		wp_set_object_terms( $object_id, $value, $field_args['taxonomy'] );
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
	public function build_children( $object, $parent_term, $saved_terms ) {
		$output = null;

		$terms = get_terms( $object->field->args( 'taxonomy' ), array(
			'hide_empty'    => false,
			'parent'        => $parent_term->term_id,
		) );

		if ( ! empty( $terms ) && is_array( $terms ) ) {
			$output = '<li style="padding-left: 24px;"><ul>';

			foreach( $terms as $term ) {
				$args = array(
					'value' => $term->slug,
					'label' => $term->name,
					'type' => 'checkbox',
					'name' => $object->_name() . '[]',
				);

				if ( is_array( $saved_terms ) && in_array( $term->slug, $saved_terms ) ) {
					$args['checked'] = 'checked';
				}

				$output .= $object->list_input( $args, $term->term_id );
				$children = $this->build_children( $object, $term, $saved_terms );

				if ( ! empty( $children ) ) {
					$output .= $children;
				}
			}

			$output .= '</ul></li>';
		}

		return $output;
	}
}

new CMB2_Field_Taxonomy_Multicheck_Hierarchy();
