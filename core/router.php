<?php
include(PATH_ROOT."/core/Response.php");

class Router
{
  
  public static $app = PATH_ROOT."app/controllers";
  public static $classname = [];
  public static $function = [];
  public static $methods = [];
  public static $routes;
  
  public static function get ($url, $controller) {
    $split_controller = explode("/", $controller);
    self::$classname[$url] = "\\".$split_controller[0];
    self::$function[$url] = $split_controller[1];
    self::$methods[$url] = "GET";
    self::$routes[$url] = self::$app.self::$classname[$url].".php";
  }

  public static function post ($url, $controller) {
    $split_controller = explode("/", $controller);
    self::$classname[$url] = "\\".$split_controller[0];
    self::$function[$url] = $split_controller[1];
    self::$methods[$url] = "POST";
    self::$routes[$url] = self::$app.self::$classname[$url].".php";
  }

  public static function put ($url, $controller) {
    $split_controller = explode("/", $controller);
    self::$classname[$url] = "\\".$split_controller[0];
    self::$function[$url] = $split_controller[1];
    self::$methods[$url] = "PUT";
    self::$routes[$url] = self::$app.self::$classname[$url].".php";
  }

  public static function delete ($url, $controller) {
    $split_controller = explode("/", $controller);
    self::$classname[$url] = "\\".$split_controller[0];
    self::$function[$url] = $split_controller[1];
    self::$methods[$url] = "DELETE";
    self::$routes[$url] = self::$app.self::$classname[$url].".php";
  }
  

  public static function run ($method, $url) {
    
    if(array_key_exists($url, self::$routes) && self::$methods[$url] == $method) {
      require(self::$routes[$url]);
      $class = new self::$classname[$url];
      $name = self::$function[$url];
      
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