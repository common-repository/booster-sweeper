<?php
// phpcs:ignore
/**
 * Description: Metabox options.
 */

if (! defined('ABSPATH')) {
    exit;
}


    /*
     * Vars
     */


    // add additional post types
    $include_post_types = isset(get_option('_booster_sweeper_options')[ 'add_post_types' ])
                        ?       get_option('_booster_sweeper_options')[ 'add_post_types' ] : '';

    $include_post_types          = ! empty($include_post_types) ? explode(' ', $include_post_types) : array();
    $include_post_types          = array_map('sanitize_title', $include_post_types);
    $_escaped_included_post_types= array_map('esc_html', $include_post_types);

    $no_options_frontend         = esc_html__('No options available -> Page has to be visited at least once on the front side to collect the resources.', 'booster-sweeper');
    $chosen_placeholder_res      = esc_html__('Select some options here...', 'booster-sweeper');

    // set frontend tab
    $frontend_tab = array(
        'title'     => esc_html__('Front', 'booster-sweeper'),
        'icon'      => 'fas fa-forward',
        'fields'    => array(
            array(
                'id'            => 'frontend_styles',
                'type'          => 'select',
                'title'         => esc_html__('Select style(s)', 'booster-sweeper'),
                'options'       => 'booster_sweeper_list_single_frontend_styles',
                'empty_message' => $no_options_frontend,
                'chosen'        => true,
                'placeholder'   => $chosen_placeholder_res,
                'multiple'      => true,
            ),
            array(
                'id'            => 'frontend_scripts',
                'type'          => 'select',
                'title'         => esc_html__('Select script(s)', 'booster-sweeper'),
                'options'       => 'booster_sweeper_list_single_frontend_scripts',
                'empty_message' => $no_options_frontend,
                'chosen'        => true,
                'placeholder'   => $chosen_placeholder_res,
                'multiple'      => true,
            ),
        )
    );


    /*
     * Differentiate options availabe on the basic & the pro version
     */
    if (function_exists('booster_sweeper_metabox_settings_pro') ) {

        $get_license = class_exists('Booster_Sweeper_Pro') && Booster_Sweeper_Pro::getLicense() !== '' ? true : false;

        if ($get_license === true) {

            $backend_tab_fields = booster_sweeper_metabox_settings_pro();

            // if license not active
        } else {

            $backend_tab_fields = array(
                array(
                    'type'     => 'callback',
                    'function' => 'booster_sweeper_license_call',
                ),
            );
        }

        // if the pro plugin isn't active
    } else {

        $backend_tab_fields = array(
            array(
                'type'     => 'callback',
                'function' => 'booster_sweeper_upgrade_call',
            ),
        );
    }


    // Gather the fields for backend tab
    $backend_tab = array(
        'title'   => esc_html__('Back', 'booster-sweeper'),
        'icon'    => 'fas fa-backward',
        'fields'  => $backend_tab_fields,
    );


    /*
     * Booster sweeper metabox.
     */

    $exclude_settings_indi = isset(get_option('_booster_sweeper_options')[ 'exclude_settings_indi' ])
                           ?       get_option('_booster_sweeper_options')[ 'exclude_settings_indi' ] : '';

    if ($exclude_settings_indi !== '1') {

        CSF::createMetabox(
            '_mb_booster_sweeper', array(
            'title'              => 'Booster Sweeper',
            'post_type'          =>  array_merge(array( 'post', 'page' ), $_escaped_included_post_types),
            'context'            => 'side',
            )
        );

        CSF::createSection(
            '_mb_booster_sweeper', array(
                'fields' => array(
                    array(
                        'id'        => 'test_mode',
                        'type'      => 'checkbox',
                        'title'        => esc_html__('Test mode', 'booster-sweeper'),
                        'help'        => esc_html__('If enabled, applied rules will be rendered only to the logged in users who can manage options, i.e. you.', 'booster-sweeper'),
                    ),
                    array(
                        'id'        => 'tabbed_options',
                        'type'      => 'tabbed',
                        'help'      => esc_html__('Switch the tabs to set all the options for Front end and Back end of the site.', 'booster-sweeper'),
                        'desc'      => esc_html__('Frontend options are updated on the actual page load, i.e. page has to be visited for options to be updated.',    'booster-sweeper'),
                        'tabs'      => array(
                            $frontend_tab,
                            $backend_tab,
                        ),
                    ),
                )
            )
        );

    }
