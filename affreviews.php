<?php
/**
 * The plugin bootstrap file
 *
 * @link              wpchop.com
 * @since             1.0.0
 * @package           Affreviews
 *
 * @wordpress-plugin
 * Plugin Name:       Affiliate Reviews
 * Description:       Custom affiliate blocks for your product, casino, forex affiliate site, using your favorite theme!
 * Version:           1.0.6
 * Author:            WPchop
 * Author URI:        https://wpchop.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       affreviews
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AFFREVIEWS_VERSION', '1.0.6' );
define( 'AFFREVIEWS_CPT', 'affreviews_reviews' );
define( 'AFFREVIEWS_TAX', 'affreviews_tax' );
define( 'AFFREVIEWS_DIR', trailingslashit( dirname( __FILE__ ) ) );
define( 'AFFREVIEWS_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Composer autoloader
 */
if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-affreviews.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_affreviews() {

	$plugin = new Affreviews();
	$plugin->run();

}
run_affreviews();
