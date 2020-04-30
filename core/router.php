<?php
namespace Router;


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
      return $this->error_404($url, self::$routes);
    }
  }
  
}