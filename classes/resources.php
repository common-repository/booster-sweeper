<?php
// phpcs:ignore
/**
 * Description: Dequeing in single page & dependent functions.
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! class_exists('Booster_Sweeper_Resources') ) {

    if (is_admin() ) {

        add_action('admin_print_styles',         [ 'Booster_Sweeper_Resources', 'find_styles' ], PHP_INT_MAX);
        add_action('admin_print_footer_scripts', [ 'Booster_Sweeper_Resources', 'find_scripts' ], PHP_INT_MAX);

        // ...and on front side
    } else if (! is_admin() ) {

        // load has to be lower in order than for the resource finding (either with priority var or by hook's order)
        add_action('wp_print_styles',           [ 'Booster_Sweeper_Resources', 'dequeue_frontend_single' ], 1);
        add_action('wp_print_footer_scripts',   [ 'Booster_Sweeper_Resources', 'dequeue_frontend_single' ], 1); // priority has to be especially low in order to pick (dequeue) the oddly added scripts, i.e. before they are printed

        // for late discovery use wp_print_footer_scripts instead of wp_print_styles:
        add_action('wp_print_footer_scripts',   [ 'Booster_Sweeper_Resources', 'find_styles' ], PHP_INT_MAX);
        add_action('wp_print_footer_scripts',   [ 'Booster_Sweeper_Resources', 'find_scripts' ], PHP_INT_MAX);

    }

    // phpcs:ignore
    class Booster_Sweeper_Resources
    {

        /**
         * Dequeue for frontend (single post/page).
         *
         * Further, updating the post meta with discovered value.
         */
        // phpcs:ignore
        public static function dequeue_frontend_single()
        {

            /*
             * @since 1.0.1
             * is_singular() must be checked, otherwise when a post has been affected
             * by BS dequeuing, if it appears as a first post on the archive pages
             * it also disturbs the scripts/styles on that archive page.
             */
            if (! is_singular() ) {
                return;
            }

            $post_id      = get_the_ID();
            $bs           = get_post_meta($post_id, '_mb_booster_sweeper', true);

            $test_mode    = isset($bs[ 'test_mode' ]) ? $bs[ 'test_mode' ] : '';
            $test_mode_on = ! empty($test_mode) && current_user_can('manage_options') ? true : false;

            $options      = isset($bs[ 'tabbed_options' ])        ? $bs[ 'tabbed_options' ]        : '';
            $styles       = isset($options[ 'frontend_styles' ])  ? $options[ 'frontend_styles' ]  : '';
            $scripts      = isset($options[ 'frontend_scripts' ]) ? $options[ 'frontend_scripts' ] : '';

            if (empty($test_mode) || $test_mode_on === true ) {

                if (! empty($styles) && is_array($styles) ) {

                    foreach ( $styles as $key => $handle ) {
                        /*
                         * Even though the $handle isn't coming from the user text
                         * input (it's the predefined selection), lets trim it for
                         * certainty.
                         */
                        wp_dequeue_style(esc_html(trim($handle)));
                    }

                }

                if (! empty($scripts) && is_array($scripts) ) {

                    foreach ( $scripts as $key => $handle ) {
                        /*
                         * Even though the $handle isn't coming from the user text
                         * input (it's the predefined selection), lets trim it for
                         * certainty.
                         */
                        wp_dequeue_script(esc_html(trim($handle)));
                    }

                }

            }

            $key_styles  = 'booster_sweeper_dequeued_styles_frontend';
            $key_scripts = 'booster_sweeper_dequeued_scripts_frontend';

            update_post_meta($post_id, $key_styles, $styles);
            update_post_meta($post_id, $key_scripts, $scripts);

        }


        /**
         * Have to set specific archive check coz Woo's shop page makes a problem.
         * This is coz shop page is considered archive, but doesn't store term meta
         * and is throwing an error notice. ( update_term_meta is used to update the
         * resouces available in other functions bellow )
         * Neither is_archive(), is_post_type_archive() or is_tax() was a solution,
         * so had to make this specific check for the is_shop.
         */
        // phpcs:ignore
        public static function page_is_archive() 
        {

            $archive = ( ! class_exists('Woocommerce') && is_archive() ) || ( class_exists('Woocommerce') && is_archive() && ! is_shop() )    ? true    : false;
            return $archive;

        }


        /**
         * Discover styles on a particular post/page/term.
         *
         * Further, updating the post/term meta with discovered value.
         */
        // phpcs:ignore
        public static function find_styles() 
        {

            $get_resources = is_admin() ? print_admin_styles() : print_late_styles();
            $key_single    = is_admin() ? 'booster_sweeper_discover_styles_backend' : 'booster_sweeper_discover_styles_frontend';
            $post_id       = get_the_ID();

            if (current_user_can('manage_options') ) {

                if (self::page_is_archive() === true ) {

                    // update term's custom field
                    update_term_meta(get_queried_object()->term_id, $key_single, $get_resources);

                } else {

                    // update post's custom field
                    update_post_meta($post_id, $key_single, $get_resources);

                }

            }

        }

        /**
         * Discover scripts on a particular post/page/term.
         *
         * Updating the post/term meta with discovered value.
         */
        // phpcs:ignore
        public static function find_scripts() 
        {

            $get_resources = wp_print_scripts();

            $key_single = is_admin() ? 'booster_sweeper_discover_scripts_backend' : 'booster_sweeper_discover_scripts_frontend'; // from backend or frontend
            $post_id    = get_the_ID();

            if (current_user_can('manage_options') ) {

                if (self::page_is_archive() === true ) {

                    // update term's custom field
                    update_term_meta(get_queried_object()->term_id, $key_single, $get_resources);

                } else {

                    // update post's custom field
                    update_post_meta($post_id, $key_single, $get_resources);

                }

            }

        }


        /**
         * Prepere the lists of resources (Single post/page).
         *
         * Preparing for use in the CSF options as a callback,
         *
         * @see booster_sweeper_list_single_frontend_styles()
         *
         * @return array The lists of frontend_styles, frontend_scripts, 
         * backend_styles, backend_scripts
         */
        // phpcs:ignore
        public static function prepare_resources_list_single() 
        {

            // for admin pages outside of posts/pages/custom post type's pages
            if (! isset($_GET['post']) ) {

                /* 
                 * make sure it returns something, i.e. '',
                 * - empty string, otherwise it will produce php error on these pages
                 */
                return array( 'frontend_styles' => '', 'frontend_scripts' => '', 'backend_styles' => '', 'backend_scripts' => '' );

            } else {

                // get queued styles/scripts
                $get_frontend_styles  = get_post_meta($_GET['post'], 'booster_sweeper_discover_styles_frontend', true);
                $get_frontend_scripts = get_post_meta($_GET['post'], 'booster_sweeper_discover_scripts_frontend', true);
                $get_backend_styles   = get_post_meta($_GET['post'], 'booster_sweeper_discover_styles_backend', true);
                $get_backend_scripts  = get_post_meta($_GET['post'], 'booster_sweeper_discover_scripts_backend', true);

                // from Indexed Array, with array_combine, create the Associative Array with the same key(s) => value(s)
                $frontend_styles  = ! empty($get_frontend_styles)  && is_array($get_frontend_styles)  ? array_combine($get_frontend_styles,  $get_frontend_styles)  : '';
                $frontend_scripts = ! empty($get_frontend_scripts) && is_array($get_frontend_scripts) ? array_combine($get_frontend_scripts, $get_frontend_scripts) : '';
                $backend_styles   = ! empty($get_backend_styles)   && is_array($get_backend_styles)   ? array_combine($get_backend_styles,   $get_backend_styles)   : '';
                $backend_scripts  = ! empty($get_backend_scripts)  && is_array($get_backend_scripts)  ? array_combine($get_backend_scripts,  $get_backend_scripts)  : '';


                // get dequeued styles/scripts
                $get_dequeued_styles_front  = get_post_meta($_GET['post'], 'booster_sweeper_dequeued_styles_frontend', true);
                $get_dequeued_scripts_front = get_post_meta($_GET['post'], 'booster_sweeper_dequeued_scripts_frontend', true);
                $get_dequeued_styles_back   = get_post_meta($_GET['post'], 'booster_sweeper_dequeued_styles_backend', true);
                $get_dequeued_scripts_back  = get_post_meta($_GET['post'], 'booster_sweeper_dequeued_scripts_backend', true);

                // from Indexed Array, with array_combine, create the Associative Array with the same key(s) => value(s)
                $dequeued_styles_frontend   = ! empty($get_dequeued_styles_front)  && is_array($get_dequeued_styles_front)  ? array_combine($get_dequeued_styles_front, $get_dequeued_styles_front)   : '';
                $dequeued_scripts_frontend  = ! empty($get_dequeued_scripts_front) && is_array($get_dequeued_scripts_front) ? array_combine($get_dequeued_scripts_front, $get_dequeued_scripts_front) : '';
                $dequeued_styles_backend    = ! empty($get_dequeued_styles_back)   && is_array($get_dequeued_styles_back)   ? array_combine($get_dequeued_styles_back, $get_dequeued_styles_back)     : '';
                $dequeued_scripts_backend   = ! empty($get_dequeued_scripts_back)  && is_array($get_dequeued_scripts_back)  ? array_combine($get_dequeued_scripts_back, $get_dequeued_scripts_back)   : '';

                // merge previously dequeued resources with the rest (otherwise the list wouldn't contain the dequeued resources and they wouldn't be available for deselection)
                $set_styles_frontend        = ! empty($get_dequeued_styles_front)  && is_array($get_dequeued_styles_front)  ? array_merge($dequeued_styles_frontend, $frontend_styles)   : $frontend_styles;
                $set_scripts_frontend       = ! empty($get_dequeued_scripts_front) && is_array($get_dequeued_scripts_front) ? array_merge($dequeued_scripts_frontend, $frontend_scripts) : $frontend_scripts;
                $set_styles_backend         = ! empty($get_dequeued_styles_back)   && is_array($get_dequeued_styles_back)   ? array_merge($dequeued_styles_backend, $backend_styles)     : $backend_styles;
                $set_scripts_backend        = ! empty($get_dequeued_scripts_back)  && is_array($get_dequeued_scripts_back)  ? array_merge($dequeued_scripts_backend, $backend_scripts)   : $backend_scripts;

                return array( 'frontend_styles' => $set_styles_frontend, 'frontend_scripts' => $set_scripts_frontend, 'backend_styles' => $set_styles_backend, 'backend_scripts' => $set_scripts_backend );

            }

        }


    }

}
