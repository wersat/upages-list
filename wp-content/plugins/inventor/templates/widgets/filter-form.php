<?php do_action( 'inventor_before_filter_form', $args ); ?>

<form method="get"
      action="<?php echo esc_attr( Inventor_Filter::get_filter_action() ); ?>"
      class="<?php if ( ! empty( $instance['live_filtering'] ) ) : ?>live <?php endif; ?><?php if ( ! empty( $instance['auto_submit_filter'] ) ) : ?>auto-submit-filter <?php endif; ?><?php if ( ! empty( $input_titles ) && 'labels' == $input_titles ) : ?>has-labels<?php endif; ?>">

    <?php do_action( '')?>
	<?php $fields = Inventor_Filter::get_fields(); ?>
	<?php if ( ! empty( $instance['sort'] ) ) : ?>
		<?php
		$keys = explode( ',', $instance['sort'] );
		$filtered_keys = array_filter( $keys );
		$fields = array_merge( array_flip( $filtered_keys ), $fields );
		?>
	<?php endif; ?>

	<?php foreach ( $fields as $key => $value ) : ?>
		<?php $is_field_visible = empty( $instance[ sprintf( 'hide_%s', $key ) ] ); ?>
		<?php $is_field_active = in_array( $key, array_keys( Inventor_Filter::get_fields() ) ); ?>

		<?php if ( $is_field_visible && $is_field_active ) : ?>
			<?php $template = str_replace( '_', '-', $key ); ?>
			<?php $plugin_dir = apply_filters( 'inventor_filter_field_plugin_dir', INVENTOR_DIR, $template ); ?>
			<?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/' . $template, $plugin_dir ); ?>
		<?php endif; ?>

	<?php endforeach; ?>

	<?php if ( ! empty( $instance['button_text'] ) && empty( $instance['auto_submit_filter'] ) ) : ?>
		<div class="form-group form-group-button">
			<button class="button" type="submit"><?php echo esc_attr( $instance['button_text'] ); ?></button>
		</div><!-- /.form-group -->
	<?php endif; ?>

	<?php if ( ! empty( $instance['sorting_options'] ) ) : ?>
		<div class="filter-sorting-options clearfix">
			<div class="filter-sorting-inner">
				<div class="filter-sorting-inner-group filter-sorting-inner-group-types">
					<strong><?php echo esc_attr__( 'Sort', 'inventor' ); ?>:</strong>

					<ul>
						<?php $sort_by_choices = apply_filters( 'inventor_filter_sort_by_choices', array() ); ?>
						<?php foreach( $sort_by_choices as $key => $value ): ?>
							<li>
								<a <?php if ( ! empty( $_GET['filter-sort-by' ] ) && $_GET['filter-sort-by'] == $key ) : ?>class="active"<?php endif; ?>>
									<?php echo $value ?>
									<input type="hidden" name="filter-sort-by" value="<?php echo esc_attr( $key ); ?>" <?php if ( empty( $_GET['filter-sort-by'] ) || $_GET['filter-sort-by'] != $key ) : ?>disabled<?php endif; ?>>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div><!-- /.filter-sorting-inner-group -->

				<div class="filter-sorting-inner-group filter-sorting-inner-group-order">
					<strong><?php echo esc_attr__( 'Order', 'inventor' ); ?>:</strong>

					<ul>
						<li>
							<a <?php if ( ! empty( $_GET['filter-sort-order' ] ) && $_GET['filter-sort-order'] == 'asc' ) : ?>class="active"<?php endif; ?>>
								<input type="hidden" name="filter-sort-order" value="asc" <?php if ( empty( $_GET['filter-sort-order'] ) || $_GET['filter-sort-order'] != 'asc' ) : ?>disabled<?php endif; ?>>
								<?php echo esc_attr__( 'Asc', 'inventor' ); ?>
							</a>
						</li>
						<li>
							<a <?php if ( ! empty( $_GET['filter-sort-order' ] ) && $_GET['filter-sort-order'] == 'desc' ) : ?>class="active"<?php endif; ?>>
								<input type="hidden" name="filter-sort-order" value="desc" <?php if ( empty( $_GET['filter-sort-order'] ) || $_GET['filter-sort-order'] != 'desc' ) : ?>disabled<?php endif; ?>>
								<?php echo esc_attr__( 'Desc', 'inventor' ); ?>
							</a>
						</li>
					</ul>
				</div><!-- /.filter-sorting-inner-group -->

				<div class="filter-sorting-inner-styles">
					<ul>
						<li>
							<a <?php if ( empty( $_GET['listing-display' ] ) || $_GET['listing-display'] == 'rows' ) : ?>class="active"<?php endif; ?>>
								<span><?php echo esc_attr__( 'Rows', 'inventor' ); ?></span>
								<input type="hidden" name="listing-display" value="rows" <?php if ( empty( $_GET['listing-display'] ) || $_GET['listing-display'] != 'rows' ) : ?>disabled<?php endif; ?>>
							</a>
						</li>

						<li>
							<a <?php if ( ! empty( $_GET['listing-display' ] ) && $_GET['listing-display'] == 'grid' ) : ?>class="active"<?php endif; ?>>
								<span><?php echo esc_attr__( 'Grid', 'inventor' ); ?></span>
								<input type="hidden" name="listing-display" value="grid" <?php if ( empty( $_GET['listing-display'] ) || $_GET['listing-display'] != 'grid' ) : ?>disabled<?php endif; ?>>
							</a>
						</li>
					</ul>
				</div>
			</div><!-- /.filter-sorting-inner -->
		</div><!-- /.filter-sorting-options -->
	<?php endif; ?>
</form>

<?php do_action( 'inventor_after_filter_form', $args ); ?>
