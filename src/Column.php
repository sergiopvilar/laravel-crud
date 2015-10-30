<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 1:15 AM
 */
class Column {

  private $fields = [];
  private static $instance;

  public static function __callStatic($name, $arguments) {
    self::getInstance()->_add($name, $arguments[0], $arguments[1]);
  }

  private function __construct() {

  }

  private static function getInstance() {
    if(empty(self::$instance)) self::$instance = new Column();
    return self::$instance;
  }

  public static function reset() {
    self::getInstance()->set([]);
  }

  public static function get() {
    return self::getInstance()->fields;
  }

  private function _add($type, $name, $label) {
    $this->fields[$name] = [$label, $type];
  }

  private function set($fields) {
    $this->fields = $fields;
  }

}
