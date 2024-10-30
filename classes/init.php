<?php
// phpcs:ignore
/**
 * Description: Plugin's initialization
 */

if (! defined('ABSPATH')) {
    exit;
}


if (! class_exists('Booster_Sweeper') ) {

    add_action('init', array( 'Booster_Sweeper', 'textdomain' ));

    /**
     * Plugin's init class.
     */
    // phpcs:ignore
    class Booster_Sweeper
    {

        /**
         * Load plugin's textdomain.
         * 
         * @return void Hooking a load_plugin_textdomain().
         */
        public static function textdomain()
        {

            load_plugin_textdomain('booster-sweeper', false, basename(dirname(__FILE__)) . '/languages');

        }


    }

}
