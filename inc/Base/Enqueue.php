<?php
/**
 * @package Custom Social Sharing
 */
namespace inc\Base;
use \inc\Base\BaseController;
class Enqueue extends BaseController{
    
public function register(){
    add_action('wp_enqueue_scripts', array($this, 'custom_social_sharing_scripts'));
}
//Enqueue styles and scripts
function custom_social_sharing_scripts() {
    wp_enqueue_style('custom-social-sharing-style', $this->plugin_url . 'asset/style.css');
    wp_enqueue_script('custom-social-sharing-script', $this->plugin_url . 'asset/script.js');
}
}