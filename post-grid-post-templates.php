<?php
/*
Plugin Name: Post Grid Post Templates by PickPlugins
Plugin URI: https://www.pickplugins.com/item/post-grid-create-awesome-grid-from-any-post-type-for-wordpress/
Description: Awesome post grid for query post from any post type and display on grid.
Version: 3.2.20
Author: PickPlugins
Author URI: https://www.pickplugins.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

if( !class_exists( 'PostGridPostTemplates' )){
    class PostGridPostTemplates{

        public function __construct(){

            define('post_grid_pt_plugin_url', plugins_url('/', __FILE__));
            define('post_grid_pt_plugin_dir', plugin_dir_path(__FILE__));
            define('post_grid_pt_plugin_basename', plugin_basename(__FILE__));
            define('post_grid_pt_plugin_name', 'Post Grid - Search');
            define('post_grid_pt_version', '1.0.0');

            include('includes/metabox-post-options-hook.php');
            include('includes/functions-single.php');


            add_action('wp_enqueue_scripts', array($this, '_scripts_front'));
            add_action('admin_enqueue_scripts', array($this, '_scripts_admin'));

            add_action('plugins_loaded', array($this, '_textdomain'));

            register_activation_hook(__FILE__, array($this, '_activation'));
            register_deactivation_hook(__FILE__, array($this, '_deactivation'));


        }


        public function _textdomain(){

            $locale = apply_filters('plugin_locale', get_locale(), 'post-grid-search');
            load_textdomain('post-grid-search', WP_LANG_DIR . '/post-grid-search/post-grid-search-' . $locale . '.mo');

            load_plugin_textdomain('post-grid-search', false, plugin_basename(dirname(__FILE__)) . '/languages/');

        }

        public function _activation(){

            /*
             * Custom action hook for plugin activation.
             * Action hook: post_grid_pt_activation
             * */
            do_action('post_grid_pt_activation');

        }

        public function post_grid_pt_uninstall(){

            /*
             * Custom action hook for plugin uninstall/delete.
             * Action hook: post_grid_pt_uninstall
             * */
            do_action('post_grid_pt_uninstall');
        }

        public function _deactivation(){

            /*
             * Custom action hook for plugin deactivation.
             * Action hook: post_grid_pt_deactivation
             * */
            do_action('post_grid_pt_deactivation');
        }


        public function _scripts_front(){

            wp_register_style('post-grid-pt', post_grid_pt_plugin_url.'assets/frontend/css/style.css');


//            wp_register_script('post_grid_pt_scripts', post_grid_pt_plugin_url. 'assets/frontend/js/scripts.js', array( 'jquery' ));
//            wp_enqueue_script('mixitup');


            /*
             * Custom action hook for scripts front.
             * Action hook: post_grid_pt_scripts_front
             * */
            do_action('post_grid_pt_scripts_front');
        }


        public function _scripts_admin(){

            //wp_register_style('post-grid-style', post_grid_pt_plugin_url.'assets/admin/css/style.css');
            //wp_enqueue_style('post-grid-style');

            /*
             * Custom action hook for scripts admin.
             * Action hook: post_grid_pt_scripts_admin
             * */
            do_action('post_grid_pt_scripts_admin');
        }


    }
}
new PostGridPostTemplates();