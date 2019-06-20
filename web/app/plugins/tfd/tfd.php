<?php

namespace TFD;

use TFD\ACF;
use TFD\CPT;

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
 * @package           Tfd_Functionality
 *
 * @wordpress-plugin
 * Plugin Name:       TFD Functionality
 * Plugin URI:        https://21st.digital
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            21st digital
 * Author URI:        https://21st.digital
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tfd-functionality
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined( 'WPINC')) {
    die;
}


if (!class_exists('TFD')) :
    class TFD
    {
        public function __construct()
        {
            spl_autoload_register(function ($class) {
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
                if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $file)) {
                    require_once($file);
                    return true;
                }
                return false;
            });
            add_action('init', [$this, 'init']);
        }

        public function init()
        {
            dlog("MOIND");
            ACF\ACF::register();
            CPT\CPT::register();
        }
    }


    function tfd()
    {
        // globals
        global $tfd;

        // initialize
        if (!isset($tfd)) {
            $tfd = new TFD();
        }
        return $tfd;
    }

    // initialize
    tfd();

endif;