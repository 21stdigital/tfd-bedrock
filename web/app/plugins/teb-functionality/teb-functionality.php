<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://21st.digital
 * @since             1.0.0
 * @package           Teb_Functionality
 *
 * @wordpress-plugin
 * Plugin Name:       TEB Functionality
 * Plugin URI:        https://21st.digital
 * Description:       Telekom Electronic Beats functionality plugin
 * Version:           1.0.0
 * Author:            21st digital
 * Author URI:        https://21st.digital
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tfd-functionality
 * Domain Path:       /languages
 */

error_log("TEB Functionality Plugin... ✅");
add_filter('tfd_cpt_location', function ($patterns) {
    error_log('tfd_cpt_location');
    return array_merge($patterns, [
        '/app/web/app/plugins/teb-functionality/CustomPostTypes/*.php',
    ]);
});
