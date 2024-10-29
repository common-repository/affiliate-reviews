<?php
/**
 * If we don't have the query then return
 */
if ( false === $params ) {
	return;
} else {
	$block_query = $params['block_query'];
	$args        = $params['args'];
}
$settings        = get_option( 'affreviews_visual_settings' );
$thumbnail_style = ( isset( $settings['thumbnail_style'] ) ? $settings['thumbnail_style'] : null );
$wrapper_class   = ( $args['numColumns'] && '2' !== $args['numColumns'] ) ? 'affr-columns-' . $args['numColumns'] : '';
?>

<div class="wp-block-affr affr-grid-wrapper <?php echo wp_kses_post( $wrapper_class ); ?>">
	<?php
	$counter = 1;
	while ( $block_query->have_posts() ) {
				$block_query->the_post();
		?>
	<div class="affr-grid-item">
		<?php
		// Counter
		echo ( $args['counter'] ) ? wp_kses_post( affreviews_get_review_count( $counter ) ) : '';

		// Tag
		echo wp_kses_post( affreviews_get_tag( get_the_ID() ) );

		// Thumbnail
		echo wp_kses_post( affreviews_get_thumb( get_the_ID(), array( $thumbnail_style ) ) );

		// Title
		echo wp_kses_post( affreviews_get_title( get_the_ID() ) );

		// Rating
		echo wp_kses( affreviews_get_rating( get_the_ID() ), affreviews_kses_extended_ruleset() );

		// Bonus
		echo wp_kses_post( affreviews_get_bonus( get_the_ID() ) );

		// Pros
		if ( ! isset( $args['hideProsCons'] ) || ! $args['hideProsCons'] ) {
			echo wp_kses( affreviews_get_pros( get_the_ID(), $args['maxProsCons'] ), affreviews_kses_extended_ruleset() );
		}

		// Review link
		echo wp_kses_post( affreviews_get_review_link( get_the_ID(), $args['reviewLinkText'] ) );

		// Review button
		echo wp_kses_post( affreviews_get_aff_button( get_the_ID(), $args['buttonText'] ) );

		// Terms and conditions
		echo wp_kses_post( affreviews_get_terms( get_the_ID() ) );
		?>
	</div>
	<!-- /.affr-grid-item -->
		<?php
		$counter++;
	}
	?>
</div>
<!-- /.affr-grid-wrapper -->
