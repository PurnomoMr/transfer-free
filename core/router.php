<?php
include(PATH_ROOT."/core/Response.php");

class Router
{

  public static $routes;
  public static $error_404;
  public static function get ($url, $controller) {
    self::$routes[$url] = $controller;
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
      return self::$routes[$url];
    } else {
      self::not_found();
    }
  }

  protected function not_found() {
      $response = new Core\response();
      $response->error("Page not found!", 404);
  }
  
}

?>