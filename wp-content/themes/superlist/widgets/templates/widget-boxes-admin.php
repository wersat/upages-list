<?php
/**
 * Widget template
 *
 * @package Superlist
 * @subpackage Widgets/Templates
 */

$title = ( isset( $instance['title'] ) ) ? $instance['title'] : '';
$description = ( isset( $instance['description'] ) ) ? $instance['description'] : '';
?>

<p>
    <?php echo esc_attr__( 'Title', 'superlist' ); ?>:
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
</p>

<p>
    <?php echo esc_attr__( 'Description', 'superlist' ); ?>:
    <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
    <?php $title_id = 'title_' . $i; ?>
    <?php $content_id = 'content_' . $i; ?>
    <?php $icon_id = 'icon_' . $i; ?>
    <?php $link_id = 'link_' . $i; ?>

    <?php $title = ! empty( $instance[ $title_id ] ) ? $instance[ $title_id ] : ''; ?>
    <?php $content = ! empty( $instance[ $content_id ] ) ? $instance[ $content_id ] : ''; ?>
    <?php $icon = ! empty( $instance[ $icon_id ] ) ? $instance[ $icon_id ] : ''; ?>
    <?php $link = ! empty( $instance[ $link_id ] ) ? $instance[ $link_id ] : ''; ?>

    <p>
    <div class="widget">
        <div class="widget-top">
            <span class="dashicons dashicons-arrow-down" style="color: #aaa; cursor: pointer; float: right; padding: 12px 12px 0px; position: relative;"></span>
            <div class="widget-title" style="cursor: pointer;">
                <h4><?php echo esc_attr( $i . '. ' . $title ); ?></h4>
            </div>
        </div>
        <div class="widget-inside">

            <p>
                <?php echo esc_attr__( 'Title:', 'superlist' ); ?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $title_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $title_id ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
            </p>

            <p>
                <?php echo esc_attr__( 'Content:', 'superlist' ); ?>
                <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( $content_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $content_id ) ); ?>"><?php echo esc_attr( $content ); ?></textarea>
            </p>

            <p>
                <?php echo esc_attr__( 'Icon Class:', 'superlist' ); ?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $icon_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $icon_id ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>"/>
                Add class in format <code>fa-[icon name]</code> (e.g. <code>fa-phone</code>).<br>See full icon list on <a href="<?php echo esc_url( 'http://fortawesome.github.io/Font-Awesome/icons/' ); ?>">FontAwesome</a>.
            </p>

            <p>
                <?php echo esc_attr__( 'Read More Link:', 'superlist' ); ?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $link_id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $link_id ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>"/>
                For example <code>http://example.com/</code>.
            </p>
        </div>
    </div>
    </p>

<?php endfor; ?>
