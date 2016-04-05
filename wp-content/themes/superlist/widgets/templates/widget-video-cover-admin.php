<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '';
$poster = ! empty( $instance['poster'] ) ? $instance['poster'] : '';
$overlay_opacity = ! empty( $instance['overlay_opacity'] ) ? $instance['overlay_opacity'] : '0.4';
$video_mp4 = ! empty( $instance['video_mp4'] ) ? $instance['video_mp4'] : '';
$video_ogg = ! empty( $instance['video_ogg'] ) ? $instance['video_ogg'] : '';
$filter = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
?>

<!-- TITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo esc_attr__( 'Title', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- SUBTITLE -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>">
		<?php echo esc_attr__( 'Subtitle', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $subtitle ); ?>">
</p>

<!-- HEIGHT -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
		<?php echo esc_attr__( 'Height', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $height ); ?>">
</p>

<!-- POSTER -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'poster' ) ); ?>">
		<?php echo esc_attr__( 'Preset Image URL', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'poster' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'poster' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $poster ); ?>">
</p>

<!-- OVERLAY OPACITY -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'overlay_opacity' ) ); ?>">
		<?php echo esc_attr__( 'Overlay opacity', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'overlay_opacity' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'overlay_opacity' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $overlay_opacity ); ?>">
</p>

<!-- VIDEO MP4 -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>">
		<?php echo esc_attr__( 'Video MP4', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'video_mp4' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $video_mp4 ); ?>">
</p>

<!-- VIDEO OGG -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'video_ogg' ) ); ?>">
		<?php echo esc_attr__( 'Video OGG', 'superlist' ); ?>
	</label>


	<input  class="widefat"
	        id="<?php echo esc_attr( $this->get_field_id( 'video_ogg' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'video_ogg' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $video_ogg ); ?>">
</p>

<?php if ( class_exists( 'Inventor' ) ) : ?>
	<!-- FILTER -->
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">
			<input 	type="checkbox"
						<?php if ( ! empty( $filter ) ) : ?>checked="checked"<?php endif; ?>
			          name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>"
			          id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>">

			<?php echo esc_attr__( 'Filter', 'superlist' ); ?>
		</label>
	</p>

	<!-- BUTTON TEXT -->
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
			<?php echo esc_attr__( 'Filter Button Text', 'superlist' ); ?>
		</label>

		<input  class="widefat"
		        id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
		        name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
		        type="text"
		        value="<?php echo esc_attr( $button_text ); ?>">
	</p>

	<!-- INPUT TITLES -->
	<h4><?php echo esc_attr__( 'Input titles', 'superlist' ); ?></h4>

	<ul>
		<li>
			<label>
				<input  type="radio"
				        class="radio"
				        value="labels"
					<?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>
					    id="<?php echo esc_attr( $this->get_field_id( 'input_titles' ) ); ?>"
					    name="<?php echo esc_attr( $this->get_field_name( 'input_titles' ) ); ?>">
				<?php echo esc_attr__( 'Labels', 'superlist' ); ?>
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
				<?php echo esc_attr__( 'Placeholders', 'superlist' ); ?>
			</label>
		</li>
	</ul>

	<h4><?php echo esc_attr__( 'Filter Fields', 'superlist' ); ?></h4>

	<?php include Inventor_Template_Loader::locate( 'widgets/filter-fields' ); ?>
<?php endif; ?>
