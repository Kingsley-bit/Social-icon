<?php
/**
 * @package Custom Social Sharing
 */
namespace inc;
final class Init{
    /**
     * store all the clasess inside an array
     * @return array full list of clasess
     */
    public static function get_services(){
        return[
            pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLink::class
        ];
    }
    /**
     * Loop through the classess, initialize them,
     *  and call the register() method if it exists
     */
 public static function register_services(){
      foreach (self::get_services() as $class) {
        $service = self::instantiate( $class);
        if (method_exists($service, 'register')) {
            $service->register();
        }
      }
  }
  /**
   * Initialize the class
   * @param class   $class class from the services array
   * @return class instance  new instance of the class
   */
  private static function instantiate($class){
    $service = new $class();
    return  $service;
  }
    
}

