<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       wpchop.com
 * @since      1.0.0
 *
 * @package    Affreviews
 * @subpackage Affreviews/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Affreviews
 * @subpackage Affreviews/admin
 * @author     WPchop <info@wpchop.com>
 */
class Affreviews_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		$screen = get_current_screen();

		// Load this stylesheet only to Reviews edit screen
		if ( ( 'post.php' === $hook && 'affreviews_reviews' === $screen->post_type ) || 'toplevel_page_affreviews-settings' === $hook ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/admin.css', array(), $this->version, 'all' );
		}

		if ( 'toplevel_page_affreviews-settings' === $hook ) {
			wp_enqueue_style( $this->plugin_name . '-public', AFFREVIEWS_URL . 'public/assets/build/public.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-review-block', AFFREVIEWS_URL . 'blocks/build/table/style-index.css', array( 'wp-components', $this->plugin_name . '-public' ), $this->version, 'all' );
			affreviews_register_css_vars( $this->plugin_name . '-review-block' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$script_dependencies = array(
			'dependencies' => null,
			'version'      => null,
		);

		if ( file_exists( __DIR__ . '/assets/build/admin.asset.php' ) ) {
			$script_dependencies = require __DIR__ . '/assets/build/admin.asset.php';
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/admin.js', $script_dependencies['dependencies'], $this->version, true );

	}

		/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register_cpt() {

		$settings = get_option( 'affreviews_general_settings' );

		//The Review Custom Post Type
		$labels = array(
			'name'               => _x( 'Reviews', 'post type general name', 'affreviews' ),
			'add_new'            => _x( 'Add New Review', 'member', 'affreviews' ),
			'add_new_item'       => __( 'Add New Review', 'affreviews' ),
			'edit_item'          => __( 'Edit', 'affreviews' ),
			'new_item'           => __( 'New Review', 'affreviews' ),
			'view_item'          => __( 'View', 'affreviews' ),
			'search_items'       => __( 'Search Reviews', 'affreviews' ),
			'not_found'          => __( 'No Reviews found!', 'affreviews' ),
			'not_found_in_trash' => __( 'No Reviews in the trash!', 'affreviews' ),
			'parent_item_colon'  => '',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'capability_type'    => 'post',
			'show_in_nav_menus'  => false,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-star-filled',
			'hierarchical'       => false,
			'supports'           => array( 'title', 'thumbnail' ),
			'has_archive'        => false,
			'show_in_rest'       => true,
		);

		if ( isset( $settings['reviews_visibility'] ) && 'visible' === $settings['reviews_visibility'] ) {
			$args['public']             = true;
			$args['publicly_queryable'] = true;
			$args['supports']           = array( 'title', 'thumbnail', 'editor' );
		}

		if ( isset( $settings['reviews_slug'] ) && 'visible' === $settings['reviews_visibility'] ) {
			$args['rewrite'] = array( 'slug' => $settings['reviews_slug'] );
		}

		register_post_type( AFFREVIEWS_CPT, $args );

		//also add a taxonomy for prp_reviews
		register_taxonomy(
			AFFREVIEWS_TAX,
			array( AFFREVIEWS_CPT ),
			array(
				'hierarchical'      => true,
				'public'            => false,
				'show_admin_column' => true,
				'show_ui'           => true,
				'query_var'         => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => 'reviews_list' ),
			)
		);
	}

	public function create_thumb_sizes() {
		add_image_size( 'affreviews-product', 400, 999999, false );
		add_image_size( 'affreviews-logo', 200, 999999, false );
	}

	/**
	 * Register custom fields metaboxes
	 *
	 * @return void
	 */
	public function register_metaboxes() {

		$affreviews_fields = new_cmb2_box(
			array(
				'id'           => 'affreviews_review_metabox',
				'title'        => esc_html__( 'Affiliate Fields', 'affreviews' ),
				'object_types' => array( AFFREVIEWS_CPT ),
			)
		);

		$affreviews_fields->add_field(
			array(
				'name'       => esc_html__( 'Rating', 'affreviews' ),
				'desc'       => esc_html__( 'The rating for this review.', 'affreviews' ),
				'id'         => 'affreviews_rating',
				'type'       => 'text',
				'attributes' => array(
					'type' => 'number',
					'min'  => '0',
					'max'  => '5',
					'step' => '0.1',
				),
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Bonus', 'affreviews' ),
				'desc' => esc_html__( 'The bonus/discount of the review. (You can use <strong> tag to emphasize the price)', 'affreviews' ),
				'id'   => 'affreviews_bonus',
				'type' => 'textarea_small',
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Affiliate link', 'affreviews' ),
				'desc' => esc_html__( 'The affiliate link of the review.', 'affreviews' ),
				'id'   => 'affreviews_afflink',
				'type' => 'text',
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Review link', 'affreviews' ),
				'desc' => esc_html__( 'The review link of the review when post type visibility is set to hidden.', 'affreviews' ),
				'id'   => 'affreviews_review_link',
				'type' => 'text',
			)
		);

		$affreviews_fields->add_field(
			array(
				'name'    => 'Logo background color',
				'id'      => 'affreviews_logo_background_color',
				'type'    => 'colorpicker',
				'default' => '',
				'desc'    => esc_html__(
					'This is used only in "logo" image type defined on plugins settings.',
					'affreviews'
				),
			),
		);

		//Positives repeatable text field.
		$affreviews_fields->add_field(
			array(
				'name'       => esc_html__( 'Positives', 'affreviews' ),
				'desc'       => esc_html__( 'The positives of the review.', 'affreviews' ),
				'id'         => 'affreviews_positives',
				'type'       => 'text',
				'repeatable' => true,
			)
		);

		//Negatives repeatable text field.
		$affreviews_fields->add_field(
			array(
				'name'       => esc_html__( 'Negatives', 'affreviews' ),
				'desc'       => esc_html__( 'The negatives of the review.', 'affreviews' ),
				'id'         => 'affreviews_negatives',
				'type'       => 'text',
				'repeatable' => true,
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Description', 'affreviews' ),
				'desc' => esc_html__( 'Small description about the review.', 'affreviews' ),
				'id'   => 'affreviews_description',
				'type' => 'textarea_small',
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Tag text', 'affreviews' ),
				'desc' => esc_html__( 'The tag is displayed over review logo.', 'affreviews' ),
				'id'   => 'affreviews_tag_text',
				'type' => 'text',
			)
		);

		$affreviews_fields->add_field(
			array(
				'name'    => 'Tag background color',
				'id'      => 'affreviews_tag_background_color',
				'type'    => 'colorpicker',
				'default' => '',
				'desc'    => esc_html__(
					'The background color of the tag.',
					'affreviews'
				),
			),
		);

		// Info list repeatable group
		$affreviews_fields_info_group = $affreviews_fields->add_field(
			array(
				'id'          => 'affreviews_group_info_list',
				'type'        => 'group',
				'description' => esc_html__( 'Information list', 'affreviews' ),
				'options'     => array(
					'group_title'   => esc_html__( 'Information list entry {#}', 'affreviews' ), // {#} gets replaced by row number
					'add_button'    => esc_html__( 'Add Another Entry', 'affreviews' ),
					'remove_button' => esc_html__( 'Remove Entry', 'affreviews' ),
					'sortable'      => true,
				),
			)
		);

		$affreviews_fields->add_group_field(
			$affreviews_fields_info_group,
			array(
				'name'            => esc_html__( 'Title', 'affreviews' ),
				'id'              => 'title',
				'type'            => 'text',
				'row_classes'     => 'cmb2-col-6 cmb2-col-first',
				'sanitization_cb' => array( $this, 'affreviews_sanitize_cmb2_html_text_field' ),
			)
		);

		$affreviews_fields->add_group_field(
			$affreviews_fields_info_group,
			array(
				'name'            => esc_html__( 'Value', 'affreviews' ),
				'id'              => 'value',
				'type'            => 'text',
				'row_classes'     => 'cmb2-col-6 cmb2-col-last',
				'sanitization_cb' => array( $this, 'affreviews_sanitize_cmb2_html_text_field' ),
			)
		);

		$affreviews_fields->add_field(
			array(
				'name' => esc_html__( 'Terms and conditions', 'affreviews' ),
				'desc' => esc_html__( 'You can add any terms that are required to be visible along with affiliate link in some countries.', 'affreviews' ),
				'id'   => 'affreviews_terms',
				'type' => 'textarea',
			)
		);

	}

	/**
	 * Sanitize CMB2 field in order to allow HTML inside
	 *
	 * @return void
	 */
	public function affreviews_sanitize_cmb2_html_text_field( $value, $field_args, $field ) {
		$value = strip_tags( $value, '<p><a><br><br/><strong>' );
		return $value;
	}

	/**
	 * Settings page
	 *
	 * @return void
	 */
	public function options_page() {

		add_menu_page(
			__( 'Affiliate Reviews', 'affreviews' ),
			__( 'Affiliate Reviews', 'affreviews' ),
			'edit_pages',
			'affreviews-settings',
			array( $this, 'page_settings' ),
			'dashicons-admin-generic',
			99
		);
	}

	/**
	 * Plugin's tables builder
	 *
	 * @since 1.0.0
	 */
	public function page_settings() {

		affreviews_get_template( 'admin/page-visual-settings.php', true, true, null );

	}

	/**
	 * Plugin's usage admin page builder
	 *
	 * @since 1.0.0
	 */
	public function page_visual_settings() {

		affreviews_get_template( 'admin/page-visual-settings.php', true, true, null );

	}

	/**
	 * Extend kses CSS filters
	 *
	 * @param [type] $styles
	 * @return void
	 */
	public function kses_extend_css_filters( $styles ) {

		$styles[] = '--affr-logo-background-color';
		return $styles;
	}

	/**
	 * Register option settings
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {

		register_setting(
			'affreviews_settings_group',
			'affreviews_visual_settings',
			array(
				'type'         => 'object',
				'default'      => array(
					'button_color'       => '#e02928',
					'button_text_color'  => '#fff',
					'button_radius'      => '5px',
					'button_padding'     => array(
						'top'    => '12px',
						'right'  => '12px',
						'bottom' => '12px',
						'left'   => '12px',
					),
					'button_font_weight' => '700',
					'button_font_size'   => '1.25rem',
					'thumbnail_style'    => 'logo-box',
					'secondary_color'    => '#4dbc24',
					'rating_color'       => '#e02928',
					'link_color'         => '#e02928',
					'box_bg_color'       => '#f9f9f9',
					'text_color'         => '#000000',
				),
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'button_color'       => array(
								'type' => 'string',
							),
							'button_text_color'  => array(
								'type' => 'string',
							),
							'button_radius'      => array(
								'type' => 'string',
							),
							'button_padding'     => array(
								'type'       => 'object',
								'properties' => array(
									'top'    => array(
										'type' => 'string',
									),
									'right'  => array(
										'type' => 'string',
									),
									'bottom' => array(
										'type' => 'string',
									),
									'left'   => array(
										'type' => 'string',
									),
								),
							),
							'button_font_weight' => array(
								'type' => 'string',
							),
							'button_font_size'   => array(
								'type' => 'string',
							),
							'thumbnail_style'    => array(
								'type' => 'string',
							),
							'secondary_color'    => array(
								'type' => 'string',
							),
							'rating_color'       => array(
								'type' => 'string',
							),
							'link_color'         => array(
								'type' => 'string',
							),
							'box_bg_color'       => array(
								'type' => 'string',
							),
							'text_color'         => array(
								'type' => 'string',
							),
						),
					),
				),
			)
		);

		register_setting(
			'affreviews_settings_group',
			'affreviews_general_settings',
			array(
				'type'         => 'object',
				'default'      => array(
					'reviews_visibility' => 'hidden',
					'reviews_slug'       => esc_attr__( 'review', 'affreviews' ),
				),
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'reviews_visibility' => array(
								'type' => 'string',
							),
							'reviews_slug'       => array(
								'type' => 'string',
							),
						),
					),
				),
			)
		);

	}

}
