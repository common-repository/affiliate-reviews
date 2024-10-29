<?php
/**
 * If we don't have the query then return
 */
if ( false === $params ) {
	return;
} else {
	$postid = $params['selectedPost'];
	if ( 0 === $postid && AFFREVIEWS_CPT === get_post_type( get_the_ID() ) ) {
		$postid = get_the_ID();
	}
}

if ( empty( $postid ) ) {
	return;
}
?>
<div class="wp-block-affr affr-pros-cons">
	<div class="affr-pros-cons-cwrap">
		<div class="affr-pros-cons-cpros">
			<?php
			// Pros
			$pros = affreviews_get_pros( $postid );
			if ( $pros ) :
				?>
			<span class="affr-title-sm"><?php echo wp_kses_post( $params['positivesTitle'] ); ?></span>
				<?php
				echo wp_kses( $pros, affreviews_kses_extended_ruleset() );
			endif;
			?>
		</div>
		<!-- /.affr-pros-cons-cpros -->
		<div class="affr-pros-cons-ccons">
			<?php
			// Cons
			$cons = affreviews_get_cons( $postid );
			if ( $cons ) :
				?>
			<span class="affr-title-sm"><?php echo wp_kses_post( $params['negativesTitle'] ); ?></span>
				<?php
				echo wp_kses( $cons, affreviews_kses_extended_ruleset() );
			endif;
			?>
		</div>
		<!-- /.affr-pros-cons-cpros -->
	</div>
	<!-- /.affr-pros-cons-cwrap -->
</div>
<!-- /.affr-block affr-pros-cons -->

