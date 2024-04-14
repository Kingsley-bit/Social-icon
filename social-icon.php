<?php
/**
 * @package Custom Social Sharing
 */
/*
Plugin Name: Custom Social Sharing
Plugin URI: https://mywebsite.com/
Description: Add customizable social sharing buttons to posts, pages, and custom post types.
Version: 1.0
Author: Ejike kingsley
Author URI: https://ejikewebsite.com/
License: GPL2
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//require once the composer autoload
if (file_exists(dirname( __FILE__) . '/vendor/autoload.php')) {
    require_once dirname( __FILE__) . '/vendor/autoload.php';
}



// code that run during plugin activation
function activate_king_social_icon(){
    inc\Base\Activate::Activate();
}
register_activation_hook( __FILE__, 'activate_king_social_icon');

// code that run during plugin deactivation
function deactivate_king_social_icon(){
    inc\Base\Deactivate::Deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_king_social_icon');


if ( class_exists('inc\\Init')){
    inc\Init::register_services();
}