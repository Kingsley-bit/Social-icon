<?php
/**
 * @package Custom Social Sharing
 */
/*
/**
 * trigger file on plugin uninstall
 */

if ( ! defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
// //clear database stored data
// $books = get_posts(array('post_type' => 'book', 'numberposts' => -1));
// foreach ($variable as $key => $value) {
//     wp_delete_post( $books->ID, true );
// }