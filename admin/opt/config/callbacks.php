<?php
// phpcs:ignore
/**
 * Description: Callback functions for options frameworks.
 */

if (! defined('ABSPATH')) {
    exit;
}

    /*
     * In general:
     * When CSF is using the callback function, from the performance perspective
     * it is better to use a function name instead of calling the function itself
     * i.e. better in CSF callback field to use 'func_name' instead of func_name():
     * http://support.codestarthemes.com/topic/is-there-a-way-to-make-a-select-field-displaying-more-than-built-in-cpt
     * So, instead of using the direct output of the class' function, lets prepere
     * the output for the use in CSF metaboxes/framework options.
     */


if (! function_exists('booster_sweeper_list_single_frontend_styles') ) {

    /**
     * List of style assets available on a particular page/post.
     * 
     * @return array.
     */
    // phpcs:ignore
    function booster_sweeper_list_single_frontend_styles()
    {
        return Booster_Sweeper_Resources::prepare_resources_list_single()[ 'frontend_styles' ];
    }

}


if (! function_exists('booster_sweeper_list_single_frontend_scripts') ) {

    /**
     * List of script assets available on a particular page/post.
     * 
     * @return array.
     */
    // phpcs:ignore
    function booster_sweeper_list_single_frontend_scripts()
    {
        return Booster_Sweeper_Resources::prepare_resources_list_single()[ 'frontend_scripts' ];
    }

}

if (! function_exists('booster_sweeper_upgrade_call') ) {

    /**
     * Upgrade notice callback for metabox.
     *
     * If Pro version isn't active, in UI it displays the call for upgrade.
     * 
     * @return string.
     */
    // phpcs:ignore
    function booster_sweeper_upgrade_call()
    {
        echo '<div style="padding: 0 10px; border-left: 4px solid #339fd4;">' .__('Upgrade to ', 'booster-sweeper') .'<a href="https://maxpressy.com/booster-sweeper/asset-cleanup-wordpress-plugin-manager/?mtm_campaign=pluginAdminUpgrade&mtm_kwd=boostersweeper" target="_blank">' .__('Pro version', 'booster-sweeper') .'</a> to gain access to premium features.</div>';
    }

}


if (! function_exists('booster_sweeper_license_call') ) {
    
    /**
     * License not active notice callback for metabox.
     *
     * If the license isn't active, in UI it displays the call for activation.
     * 
     * @return string.
     */
    // phpcs:ignore
    function booster_sweeper_license_call()
    {

        echo '<h2>' .esc_html('License inactive', 'booster-sweeper') .'</h2>';
        echo  '<p>' .esc_html('Please do activate your Booster Sweeper Pro license ', 'booster-sweeper') .'<a href="' .esc_url(admin_url('admin.php?page=booster-sweeper-licenses')) .'" target="_self">' .__('here', 'booster-sweeper') .'</a>' .esc_html(' to gain access to premium features. Most likely you see this message because your license has expired or you deactivated it.', 'booster-sweeper') .'</p>';
        echo  '<p>' .esc_html('IMPORTANT: Saving the options without the license active will cause in losing the previously saved premium settings.', 'booster-sweeper') .'</p>';

    }

}
