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

<div class="wp-block-affr affr-table-wrapper--large">
	<?php
	$counter = 1;
	while ( $block_query->have_posts() ) {
				$block_query->the_post();
		?>
	<div class="affr-table-item">
		<div class="affr-table-item-cthumb">
			<?php
			// Counter
			echo ( $args['counter'] ) ? wp_kses_post( affreviews_get_review_count( $counter ) ) : '';

			// Tag
			echo wp_kses_post( affreviews_get_tag( get_the_ID() ) );

			// Thumbnail
			echo wp_kses_post( affreviews_get_thumb( get_the_ID(), array( $thumbnail_style ) ) );

			// Title
			echo wp_kses_post( affreviews_get_title( get_the_ID() ) );
			?>
		</div>
		<!-- /.affr-table-item-cthumb -->

		<div class="affr-table-item-cwide">
			<div class="affr-table-item-rwide">
				<?php
					// Rating
					echo wp_kses( affreviews_get_rating( get_the_ID() ), affreviews_kses_extended_ruleset() );

					// Bonus
					echo wp_kses_post( affreviews_get_bonus( get_the_ID() ) );
				?>
			</div>
			<!-- /.affr-table-item-rwide -->
			<div class="affr-table-item-rwide">
				<?php
					// Pros
					echo wp_kses( affreviews_get_pros( get_the_ID(), $args['maxProsCons'] ), affreviews_kses_extended_ruleset() );

					// Cons
					echo wp_kses( affreviews_get_cons( get_the_ID(), $args['maxProsCons'] ), affreviews_kses_extended_ruleset() );
				?>
			</div>
			<!-- /.affr-table-item-rwide -->
			<div class="affr-table-item-rwide">
				<div class="affr-description">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec nunc nulla. Nulla felis metus, imperdiet ac ornare sed, posuere maximus risus. Integer et varius orci. Fusce venenatis fermentum libero. Mauris ut sem finibus, tristique nulla sit amet, mollis dui. Donec dolor mi, maximus non rhoncus vel, ultricies id nulla. Nulla fermentum varius mauris ac luctus.
				</div>
				<!-- /.affr-description -->
			</div>
			<!-- /.affr-table-item-rwide -->
			<div class="affr-table-item-rwide affr-table-item-rwide--center">
				<?php
				// Review button
				echo wp_kses_post( affreviews_get_aff_button( get_the_ID(), $args['buttonText'] ) );

				// Review link
				echo wp_kses_post( affreviews_get_review_link( get_the_ID(), $args['reviewLinkText'] ) );
				?>
			</div>
			<!-- /.affr-table-item-rwide -->
		</div>
		<!-- /.affr-table-item-cwide -->

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
	<!-- /.affr-table-item -->
		<?php
		$counter++;
	}
	?>
</div>
<!-- /.affr-table-wrapper -->
