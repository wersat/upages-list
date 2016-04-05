<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $_GET['marker-style'] ) && $_GET['marker-style'] == 'inventor-poi' ) : ?>
	<?php $poi = Inventor_Post_Type_Listing::get_inventor_poi(); ?>
	<div class="marker-inventor-poi"><div class="marker-inventor-poi-inner">
		<?php if ( ! empty( $poi ) ) : ?>
			<i class="inventor-poi <?php echo $poi; ?>"></i>
		<?php else : ?>
			<i class="inventor-poi inventor-poi-information"></i>
		<?php endif; ?>
	</div></div>
<?php else : ?>
	<div class="marker"><div class="marker-inner"></div></div>
<?php endif; ?>
