<?php
include(PATH_ROOT."/core/Response.php");

class Router
{
  
  public static $app = PATH_ROOT."app/controllers";
  public static $classname = "";
  public static $function = "";
  public static $routes;
  public static $error_404;
  public static function get ($url, $controller) {
    $split_controller = explode("/", $controller);
    self::$classname = "\\".$split_controller[0];
    self::$function = $split_controller[1];
    self::$routes[$url] = self::$app.self::$classname.".php";
  }

  public static function post ($url, $controller) {
    self::$routes[$url] = $controller;
  }

  public static function put ($url, $controller) {
    self::$routes[$url] = $controller;
  }

  public static function delete ($url, $controller) {
    self::$routes[$url] = $controller;
  }
  
  public static function error_404 ($url, $controller) {
    return self::$error_404[$url] = $controller;
  }

  public static function run ($url) {
    
    if(array_key_exists($url, self::$routes)) {
      require(self::$routes[$url]);
      $class = new self::$classname;
      $name = self::$function;
      
      return $class->$name();
    } else {
      self::not_found();
    }
  }

  protected static function not_found() {
      $response = new Core\response();
      $response->error("Page not found!", 404);
  }
  
}

?>