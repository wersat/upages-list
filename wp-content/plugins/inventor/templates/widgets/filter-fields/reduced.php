<?php if ( empty( $instance['hide_reduced'] ) ) : ?>
	<div class="form-group">
		<div class="checkbox">
			<label for="<?php echo esc_attr( $args['widget_id'] ); ?>_reduced">
				<input type="checkbox" name="filter-reduced" <?php echo ! empty( $_GET['filter-reduced'] ) ? 'checked' : ''; ?> id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reduced">			
				<?php echo __( 'Reduced', 'inventor' ); ?>
			</label>
		</div><!-- /.checkbox -->
	</div><!-- /.form-group -->
<?php endif; ?>