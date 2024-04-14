<?php
/**
 * @package Custom Social Sharing
 */
namespace inc\Base;
use \inc\Base\BaseController;


class SettingsLink extends BaseController{
    
    public function register(){
        add_filter("plugin_action_links_$this->plugin", array($this,'settings_link'));

    }
    public function settings_link($links){
            //add custom settings link
            $setting_link = '<a href="options-general.php?page=custom-social-sharing-options">settings</a>';
            array_push( $links, $setting_link);
            return $links;
        }
}
    
