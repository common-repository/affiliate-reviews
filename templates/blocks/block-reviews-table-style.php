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
?>

<div class="wp-block-affr affr-table-wrapper">
	<?php
	$counter = 1;
	while ( $block_query->have_posts() ) {
				$block_query->the_post();
		?>
	<div class="affr-table-item">

		<div class="affr-table-item-cwrap">
			<div class="affr-table-item-cthumb">
				<?php
				// Counter
				echo ( $args['counter'] ) ? wp_kses_post( affreviews_get_review_count( $counter ) ) : '';

				// Tag
				echo wp_kses_post( affreviews_get_tag( get_the_ID() ) );

				// Thumbnail
				echo wp_kses_post( affreviews_get_thumb( get_the_ID(), array( $thumbnail_style ) ) );
				?>
			</div>
			<!-- /.affr-table-item-cthumb -->

			<div class="affr-table-item-crating">
				<?php
				// Title
				echo wp_kses_post( affreviews_get_title( get_the_ID() ) );

				// Review link
				echo wp_kses_post( affreviews_get_review_link( get_the_ID(), $args['reviewLinkText'] ) );

				// Rating
				echo wp_kses( affreviews_get_rating( get_the_ID() ), affreviews_kses_extended_ruleset() );
				?>
			</div>
			<!-- /.affr-table-item-crating -->

			<div class="affr-table-item-cpros">
				<?php
				// Pros
				echo wp_kses( affreviews_get_pros( get_the_ID(), $args['maxProsCons'] ), affreviews_kses_extended_ruleset() );
				?>
			</div>
			<!-- /.affr-table-item-cpros -->

			<?php if ( $terms = affreviews_get_terms( get_the_ID() ) ) : ?>
			<div class="affr-table-item-cterms">
				<?php
				// Terms and conditions
				echo wp_kses_post( $terms );
				?>
			</div>
			<!-- /.affr-table-item-cterms -->
			<?php endif; ?>
		</div>
		<!-- /.affr-table-item-cwrap -->

		<div class="affr-table-item-cbonus">
			<?php
			// Bonus
			echo wp_kses_post( affreviews_get_bonus( get_the_ID() ) );

			// Review button
			echo wp_kses_post( affreviews_get_aff_button( get_the_ID(), $args['buttonText'] ) );

			// Terms and conditions
			echo wp_kses_post( $terms );
			?>
		</div>
		<!-- /.affr-table-item-cbonus -->
	</div>
	<!-- /.affr-table-item -->
		<?php
		$counter++;
	}
	?>
</div>
<!-- /.affr-table-wrapper -->
