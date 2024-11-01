<?php
/*
Plugin Name: Vanilla Bean - Custom Login
Plugin URI: http://www.velvary.com.au/vanilla-beans/wordpress/theme-login/
Description: Provides easy access to change your login screen layout and logo to match your theme. Vanilla Beans for Wordpress by Velvary
Version: 3.7.1
Author: vsmash
Author URI: http://www.velvary.com.au
License: GPLv2
*/


            // If this file is called directly, abort.
            if ( ! defined( 'WPINC' ) ) {
                    die;
            }

            if ( !defined( 'VBEANTHEMELOGIN_PLUGIN_DIR' ) ) {
                    define( 'VBEANTHEMELOGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }
            if ( !defined( 'VBEANTHEMELOGIN_PLUGIN_URL' ) ) {
                    define( 'VBEANTHEMELOGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }
            if ( !defined( 'VBEANTHEMELOGIN_PLUGIN_FILE' ) ) {
                    define( 'VBEANTHEMELOGIN_PLUGIN_FILE', __FILE__ );
            }
            if ( !defined( 'VBEANTHEMELOGIN_PLUGIN_VERSION' ) ) {
                    define( 'VBEANTHEMELOGIN_PLUGIN_VERSION', '3.60' );
            }


            if ( !defined( 'VBEANTHEMELOGIN_NOLOGO_LOGINTEMPLATE' ) ) {
                    define( 'VBEANTHEMELOGIN_NOLOGO_LOGINTEMPLATE', '               body.login div#login h1 a {                background-image: URL() !important;                padding-bottom: 0;                text-indent:0 !important;                }                body.login div#login h1 {width:100% !important;}                body.login h1 a{                width:100% !important;                background-size: 100% 114px !important;                background-image: URL() !important;                }            ' );
            }
            if ( !defined( 'VBEANTHEMELOGIN_LOGO_LOGINTEMPLATE' ) ) {
                    define( 'VBEANTHEMELOGIN_LOGO_LOGINTEMPLATE', '                  body.login div#login h1 a {                        background-image: url(##logourl##);                        padding-bottom: 30px;                    }                ' );
            }
            
            

            /*===========================================
                    Define Includes
            ===========================================*/
            $includes = array(
                'functions.php',
                'themelogin.php'
            );

            $frontend_includes = array(
            );

            $adminincludes= array(
                'settings.php'
            );

            /*===========================================
                    Load Includes
            ===========================================*/
            // Common
            foreach ( $includes as $include ) {
                    require_once( dirname( __FILE__ ) . '/inc/'. $include );
            }
            if(is_admin()){		
            //load admin part
                
                add_action('admin_init','vbean_themelogin_colourpicker');
                foreach ( $adminincludes as $admininclude ) {
                    require_once( dirname( __FILE__ ) . '/inc/admin/'. $admininclude );
                }
                
                }else{
            //load front part
                foreach ( $frontend_includes as $include ) {
                        require_once( dirname( __FILE__ ) . '/inc/'. $include );
                }
            }

            add_action('admin_menu', 'vbean_themelogin_create_menu');

            if(!function_exists('vbean_themelogin_create_menu')){
            
            function vbean_themelogin_create_menu() {


            if ( empty ( $GLOBALS['admin_page_hooks']['vanillabeans-settings'] ) ){
            //create new top-level menu
        	add_menu_page('Vanilla Beans', 'Vanilla Beans', 'administrator', 'vanillabeans-settings', 'VanillaBeans\LiveSettings', VBEANTHEMELOGIN_PLUGIN_URL.'vicon.png', 4);
            }
            add_submenu_page('vanillabeans-settings', 'Theme Login', 'Theme Login', 'administrator', __FILE__,'VanillaBeans\ThemeLogin\vbean_rendersettings');

                    //call register settings function
                    add_action( 'admin_init', 'VanillaBeans\Themelogin\RegisterSettings' );
            }
            }
            
            
            
            if(!function_exists('vbean_themelogin_colourpicker')){
            function vbean_themelogin_colourpicker(){
                wp_register_style(
                'vbean-themelogin-colorpicker-styles', // handle name
                plugins_url('/inc/assets/spectrum.css', __FILE__), // the URL of the stylesheet
                array( ), // an array of dependent styles
                'screen' // CSS media type
                );
                wp_register_script( 'vbean-themelogin-colorpicker', plugins_url( '/inc/assets/spectrum.js', __FILE__ ),
                    array( 'jquery' ) );    
                wp_enqueue_script(
		'vbean-themelogin-colorpicker'
                );
                wp_enqueue_style( 'vbean-themelogin-colorpicker-styles' );  
            }
            }else{
            }
    
        


