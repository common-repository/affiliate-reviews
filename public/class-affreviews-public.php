<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       wpchop.com
 * @since      1.0.0
 *
 * @package    Affreviews
 * @subpackage Affreviews/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Affreviews
 * @subpackage Affreviews/public
 * @author     WPchop <info@wpchop.com>
 */
class Affreviews_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$script_dependencies = array(
			'dependencies' => null,
			'version'      => null,
		);

		if ( file_exists( __DIR__ . '/assets/build/public.asset.php' ) ) {
			$script_dependencies = require __DIR__ . '/assets/build/public.asset.php';
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/public.js', $script_dependencies['dependencies'], $this->version, false );

	}

	/**
	 * Set CSS vars to head
	 *
	 * @return void
	 */
	public function register_css_vars() {
		affreviews_register_css_vars( $this->plugin_name );
	}

}
