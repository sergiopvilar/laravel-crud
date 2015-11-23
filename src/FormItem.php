<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 1:06 AM
 */
class FormItem {

  private $fields = [];
  private static $instance;

  public static function __callStatic($name, $arguments) {
    $default = (!empty($arguments[2])) ? $arguments[2] : false;
    self::getInstance()->_add($name, $arguments[0], $arguments[1], $default);
  }

  private function __construct() {

  }

  private static function getInstance() {
    if(empty(self::$instance)) self::$instance = new FormItem();
    return self::$instance;
  }

  public static function reset() {
    self::getInstance()->set([]);
  }

  public static function get() {
    return self::getInstance()->fields;
  }

  private function _add($type, $name, $label, $default) {
    $this->fields[$name] = [$label, $type, $default];
  }

  private function set($fields) {
    $this->fields = $fields;
  }

}
