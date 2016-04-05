<?php if ( empty( $instance['hide_price'] ) ) : ?>
	<div class="form-group form-group-price form-group-price-from">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from"><?php echo __( 'Price from', 'inventor' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-price-from"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price from', 'inventor' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-price-from'] ) ? $_GET['filter-price-from'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_from">
	</div><!-- /.form-group -->

	<div class="form-group form-group-price form-group-price-to">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to"><?php echo __( 'Price to', 'inventor' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-price-to"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo __( 'Price to', 'inventor' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-price-to'] ) ? $_GET['filter-price-to'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_price_to">
	</div><!-- /.form-group -->
<?php endif; ?>