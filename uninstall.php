<?php
// phpcs:ignore
/**
 * Description: Optionally, on user choise,
 * get the plugin's options removed from a database on uninstall
 */

if (! defined('ABSPATH')) {
    exit;
}

// if uninstall.php is not called by WordPress, die
if (! defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}


// uninstall if user prompts it
$uninstall_setting = isset(get_option('_booster_sweeper_options')[ 'uninstall_setting' ])
                   ?       get_option('_booster_sweeper_options')[ 'uninstall_setting' ] : '';

if (! empty($uninstall_setting) ) {

    $option_name = '_booster_sweeper_options';

    delete_option($option_name);

}
