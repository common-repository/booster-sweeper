<?php
// phpcs:ignore
/**
 * Description: Cleanup unnecessary html output
 */

if (! defined('ABSPATH') ) {
    exit;
}


if (! function_exists('booster_sweeper_head_cleanup') ) {

    /**
     * Head cleanup.
     */
    // phpcs:ignore
    function booster_sweeper_head_cleanup()
    {

        $tag_generator  = isset(get_option('_booster_sweeper_options')[ 'html_tag_generator' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_tag_generator' ] : '';

        $tag_rsd        = isset(get_option('_booster_sweeper_options')[ 'html_tag_rsd' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_tag_rsd' ] : '';

        $tag_wlw        = isset(get_option('_booster_sweeper_options')[ 'html_tag_wlw' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_tag_wlw' ] : '';

        $tag_shortlink  = isset(get_option('_booster_sweeper_options')[ 'html_tag_shortlink' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_tag_shortlink' ] : '';

        $tag_prev       = isset(get_option('_booster_sweeper_options')[ 'html_tag_prev' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_tag_prev' ] : '';

        $links_restapi  = isset(get_option('_booster_sweeper_options')[ 'html_links_rest_api' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_links_rest_api' ] : '';

        $links_oembed   = isset(get_option('_booster_sweeper_options')[ 'html_links_oembed' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_links_oembed' ] : '';

        $links_feed     = isset(get_option('_booster_sweeper_options')[ 'html_links_feed' ])
                        ?       get_option('_booster_sweeper_options')[ 'html_links_feed' ] : '';

        // WP version
        if (! empty($tag_generator) ) {
            remove_action('wp_head', 'wp_generator');

            // and hide it from RSS
            add_filter('the_generator', '__return_false');
        }

        // 3rd party editor link
        if (! empty($tag_rsd) ) {
            remove_action('wp_head', 'rsd_link');
        }

        // windows live writer
        if (! empty($tag_wlw) ) {
            remove_action('wp_head', 'wlwmanifest_link');
        }

        // Shortlink, i.e. rel='shortlink'
        if (! empty($tag_shortlink) ) {
            remove_action('wp_head', 'wp_shortlink_wp_head');

            // ,,,from the "Response Headers"
            remove_action('template_redirect', 'wp_shortlink_header', 11);
        }

        // "Post's adjacent Links", i.e. rel='prev'
        if (! empty($tag_prev)) {
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
        }

        // "REST API" links, i.e. rel='https://api.w.org/' 
        // AND href='https://site.com/wp-json/' />
        if (! empty($links_restapi) ) {
            remove_action('wp_head', 'rest_output_link_wp_head');

            // ...do it in the "Response Headers"
            remove_action('template_redirect', 'rest_output_link_header', 11);

        }

        // oEmbed
        if (! empty($links_oembed) ) {
            remove_action('wp_head', 'wp_oembed_add_discovery_links');
        }

        // feeds
        if (! empty($links_feed) ) {
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'feed_links', 2);
        }

    }

    add_action('init', 'booster_sweeper_head_cleanup');

}



if (! function_exists('booster_sweeper_disable_emojis') ) {

    /**
     * Remove support for emojis.
     */
    // phpcs:ignore
    function booster_sweeper_disable_emojis()
    {

        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        remove_action('wp_print_styles', 'print_emoji_styles');


    }

    $remove_emojis = isset(get_option('_booster_sweeper_options')[ 'html_emojis' ])
                   ?       get_option('_booster_sweeper_options')[ 'html_emojis' ] : '';

    if (! empty($remove_emojis) ) {
        add_action('init', 'booster_sweeper_disable_emojis');
    }

}
