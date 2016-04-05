<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : '';
$result_numbers_enabled = isset( $instance[ 'result_numbers_enabled' ] ) ? $instance[ 'result_numbers_enabled' ] : '';
$result_numbers_total = isset( $instance[ 'result_numbers_total' ] ) ? $instance[ 'result_numbers_total' ] : '';
$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';
$sorting_options = ! empty( $instance['sorting_options'] ) ? $instance['sorting_options'] : '';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo __( 'Title', 'inventor' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- BUTTON TEXT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
		<?php echo __( 'Button text', 'inventor' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $button_text ); ?>">
</p>

<!-- DISPLAY SORTING OPTIONS -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'sorting_options' ) ); ?>">
		<input 	type="checkbox"
		          <?php if ( ! empty( $sorting_options ) ) : ?>checked="checked"<?php endif; ?>
		          name="<?php echo esc_attr( $this->get_field_name( 'sorting_options' ) ); ?>"
		          id="<?php echo esc_attr( $this->get_field_id( 'sorting_options' ) ); ?>">

		<?php echo __( 'Sorting Options', 'inventor' ); ?>
	</label>
</p>

<!-- INPUT TITLES -->
<label><?php echo __( 'Input titles', 'inventor' ); ?></label>

<ul>
	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="labels"
				<?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>
			        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
			<?php echo __( 'Labels', 'inventor' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input  type="radio"
			        class="radio"
			        value="placeholders"
				<?php echo ( 'placeholders' == $input_titles ) ? 'checked="checked"' : ''; ?>
			        id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
			<?php echo __( 'Placeholders', 'inventor' ); ?>
		</label>
	</li>
</ul>

<!-- RESULT NUMBERS -->
<label><?php echo __( 'Result numbers', 'inventor' ); ?></label>

<ul>
	<li>
		<label>
			<input	class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'result_numbers_enabled' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'result_numbers_enabled' ) ); ?>"
					type="checkbox"
					value=1
			<?php checked( $result_numbers_enabled, 1 ); ?>>
			<?php echo __( 'Show result numbers', 'inventor' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input 	class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'result_numbers_total' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'result_numbers_total' ) ); ?>"
					type="checkbox"
					value=1
			<?php checked( $result_numbers_total, 1 ); ?>>
			<?php echo __( 'Show total count', 'inventor' ); ?>
		</label>
	</li>
</ul>

<hr>

<?php include Inventor_Template_Loader::locate( 'widgets/filter-fields' ); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var enabled_selector = "[id$='result_numbers_enabled']";
		var total_selector = "[id$='result_numbers_total']";
		var result_numbers_enabled = $("#widgets-right " + enabled_selector);
		var result_numbers_total = $("#widgets-right " + total_selector);

		result_numbers_enabled.change(function() {
			if(!$(this).is(':checked')) {
				var form = $(this).closest('form');
				form.find(total_selector).prop('checked', false);
			}
		}).change();

		result_numbers_total.change(function() {
			if($(this).is(':checked')) {
				var form = $(this).closest('form');
				form.find(enabled_selector).prop('checked', true);
			}
		}).change();
	});
</script>