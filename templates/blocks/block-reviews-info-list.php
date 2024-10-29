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
<div class="wp-block-affr affr-info-list-wrapper">
	<span class="affr-title-sm"><?php echo wp_kses_post( $params['infoTitle'] ); ?></span>
	<?php
	// Information list
	echo wp_kses( affreviews_get_infolist( $postid ), affreviews_kses_extended_ruleset() );
	?>
</div>
<!-- /.affr-block affr-info-list-wrapper -->

