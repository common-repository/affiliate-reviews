<?php

/**
 * Blocks render functionality.
 *
 * @link       wpchop.com
 * @since      1.0.0
 *
 * @package    Affreviews
 * @subpackage Affreviews/render-blocks
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Affreviews
 * @subpackage Affreviews/render-blocks
 * @author     WPchop <info@wpchop.com>
 */
class Affreviews_Blocks {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register our blocks.
	 *
	 * @since    1.0.0
	 */
	public function register_blocks() {

		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/table',
			array(
				'render_callback' => array( $this, 'callback_block_table' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/grid',
			array(
				'render_callback' => array( $this, 'callback_block_grid' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/table-large',
			array(
				'render_callback' => array( $this, 'callback_block_table_large' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/single',
			array(
				'render_callback' => array( $this, 'callback_block_single' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/single-large',
			array(
				'render_callback' => array( $this, 'callback_block_single_large' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/pros-cons',
			array(
				'render_callback' => array( $this, 'callback_block_pros_cons' ),
			)
		);
		register_block_type(
			AFFREVIEWS_DIR . 'blocks/build/info-list',
			array(
				'render_callback' => array( $this, 'callback_block_info_list' ),
			)
		);

	}

	/**
	 * Callback for table block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_table( $args, $content ) {

		$query_args = $this->build_blocks_query_args( $args );

		$block_query = new WP_Query( $query_args );

		$output = '';

		$params = array(
			'block_query' => $block_query,
			'args'        => $args,
		);

		if ( $block_query->have_posts() ) {

			ob_start();

			affreviews_get_template( 'blocks/block-reviews-table-style.php', true, false, $params );

			$output = ob_get_clean();

		}

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Callback for grid block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_grid( $args, $content ) {

		$query_args = $this->build_blocks_query_args( $args );

		$block_query = new WP_Query( $query_args );

		$output = '';

		$params = array(
			'block_query' => $block_query,
			'args'        => $args,
		);

		if ( $block_query->have_posts() ) {

			ob_start();

			affreviews_get_template( 'blocks/block-reviews-grid-style.php', true, false, $params );

			$output = ob_get_clean();

		}

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Callback for table large block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_table_large( $args, $content ) {

		$query_args = $this->build_blocks_query_args( $args );

		$block_query = new WP_Query( $query_args );

		$output = '';

		$params = array(
			'block_query' => $block_query,
			'args'        => $args,
		);

		if ( $block_query->have_posts() ) {

			ob_start();

			affreviews_get_template( 'blocks/block-reviews-table-style-large.php', true, false, $params );

			$output = ob_get_clean();

		}

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Create the query for tables and lists
	 *
	 * @param [type] $args
	 * @return array
	 */
	public function build_blocks_query_args( $args ) {
		$num            = $args['num'] ?? '6';
		$selected_posts = $args['selectedPosts'] ?? '';
		$categories     = $args['categories'] ?? '';
		$orderby        = $args['orderby'] ?? '';
		$order          = $args['order'] ?? '';
		$output         = '';

		$query_args = array(
			'post_type'           => AFFREVIEWS_CPT,
			'posts_per_page'      => $num,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		// Ordering and define spefici reviews
		if ( ! empty( $selected_posts ) && is_array( $selected_posts ) ) {
			$query_args['post__in'] = $selected_posts;
			$query_args['orderby']  = 'post__in';
			$query_args['order']    = 'ASC';
		} else {
			if ( 'rating' === $orderby ) {
				$query_args['meta_key'] = 'affreviews_rating';
				$query_args['orderby']  = 'meta_value_num';
			} else {
				$query_args['orderby'] = $orderby;
			}
			$query_args['order'] = $order;
		}

		// Specific terms
		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => AFFREVIEWS_TAX,
					'field'    => 'term_id',
					'terms'    => $categories,
					'operator' => 'AND',
				),
			);
		}

		return $query_args;
	}

	/**
	 * Callback for Single block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_single( $args, $content ) {
		$output = '';

		ob_start();

		affreviews_get_template( 'blocks/block-reviews-single.php', true, false, $args );

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Callback for Single block large
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_single_large( $args, $content ) {
		$output = '';

		ob_start();

		affreviews_get_template( 'blocks/block-reviews-single-large.php', true, false, $args );

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Callback for ProsCons block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_pros_cons( $args, $content ) {
		$output = '';

		ob_start();

		affreviews_get_template( 'blocks/block-reviews-pros-cons.php', true, false, $args );

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Callback for Info List block
	 *
	 * @param [type] $args
	 * @param [type] $content
	 * @return void
	 */
	public function callback_block_info_list( $args, $content ) {
		$output = '';

		ob_start();

		affreviews_get_template( 'blocks/block-reviews-info-list.php', true, false, $args );

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Register custom styles inside editor
	 *
	 * @return void
	 */
	public function register_editor_styles() {
		wp_enqueue_style( $this->plugin_name, AFFREVIEWS_URL . 'public/assets/build/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Block category
	 *
	 * @return void
	 */
	public function register_block_categories() {
		$categories[] = array(
			'slug'  => 'affreviews',
			'title' => 'Affiliate Reviews',
		);

		return $categories;
	}
}
