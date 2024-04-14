<?php
/**
 * @package Custom Social Sharing
 */
namespace inc\Base;
 class Deactivate{
    public static function Deactivate(){
            flush_rewrite_rules();
           }
    
    }