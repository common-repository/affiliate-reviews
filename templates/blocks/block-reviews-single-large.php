<?php
/**
 * If we don't have the query then return
 */
if ( false === $params ) {
	return;
} else {
	$postid = $params['selectedPost'] ?? '';
	if ( 0 === $postid && AFFREVIEWS_CPT === get_post_type( get_the_ID() ) ) {
		$postid = get_the_ID();
	}
}

if ( empty( $postid ) ) {
	return;
}

$settings        = get_option( 'affreviews_visual_settings' );
$thumbnail_style = ( isset( $settings['thumbnail_style'] ) ? $settings['thumbnail_style'] : null );
?>

<div class="wp-block-affr affr-single affr-single--large">
	<div class="affr-single-cwrap">
		<div class="affr-single-cthumb">
			<?php
			// Thumbnail
			echo wp_kses_post( affreviews_get_thumb( $postid, array( $thumbnail_style ) ) );
			?>
		</div>
		<!-- /.affr-single-cthumb -->
		<div class="affr-single-ccontent">
			<div class="affr-single-rating-bonus">
				<?php
				// Rating
				echo wp_kses( affreviews_get_rating( $postid ), affreviews_kses_extended_ruleset() );

				// Bonus
				echo wp_kses_post( affreviews_get_bonus( $postid ) );
				?>
			</div>
			<!-- /.affr-single-rating-bonus -->
			<?php
				// Description
				echo wp_kses_post( affreviews_get_description( $postid ) );
			?>
			<div class="affr-single-cwrap">
				<div class="affr-single-cpros-cons">
					<?php
					// Pros
					$pros = affreviews_get_pros( $postid );
					if ( $pros ) :
						?>
					<span class="affr-title-sm"><?php esc_attr_e( 'Positives', 'affreviews' ); ?></span>
						<?php
						echo wp_kses( $pros, affreviews_kses_extended_ruleset() );
					endif;

					// Cons
					$cons = affreviews_get_cons( $postid );
					if ( $cons ) :
						?>
					<span class="affr-title-sm"><?php esc_attr_e( 'Negatives', 'affreviews' ); ?></span>
						<?php
						echo wp_kses( $cons, affreviews_kses_extended_ruleset() );
					endif;
					?>
				</div>
				<!-- /.affr-single-cpros-cons -->

				<div class="affr-single-cdetails">
					<span class="affr-title-sm"><?php esc_attr_e( 'Information', 'affreviews' ); ?></span>
					<?php
					// Information list
					echo wp_kses( affreviews_get_infolist( $postid ), affreviews_kses_extended_ruleset() );
					?>
				</div>
				<!-- /.affr-single-cdetails -->

			</div>
			<!-- /.affr-single-cwrap -->
			<?php
			// Review button
			echo wp_kses_post( affreviews_get_aff_button( $postid, $params['buttonText'] ) );
			?>
		</div>
		<!-- /.affr-single-ccontent -->
		<?php
		$terms = affreviews_get_terms( $postid );
		if ( $terms ) :
			?>
		<div class="affr-single-terms">
			<?php
			// Terms and conditions
			echo wp_kses_post( $terms )
			?>
		</div>
		<!-- /.affr-single-terms -->
		<?php endif; ?>
	</div>
	<!-- /.affr-single-cwrap -->
</div>
<!-- /.affr-block -->
