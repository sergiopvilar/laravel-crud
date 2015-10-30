<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 12:41 AM
 */
class Admin {

  private static $instance;
  private $items = [];

  private function __construct() {

  }

  private static function getInstance() {
    if (empty(self::$instance)) self::$instance = new Admin();
    return self::$instance;
  }

  public static function model($model) {
    $item = new AdminItem($model);
    self::getInstance()->add($item);
    return $item;
  }

  public function add($item) {
    array_push($this->items, $item);
  }

  public static function get() {
    return self::getInstance()->items;
  }

  public static function getByPath($path) {
    $items = self::get();
    foreach($items as $item) {
      if($item->model == $path) return $item;
    }
  }

  public static function getLinks() {
    $links = [];
    foreach(Admin::get() as $model){
      $obj = new \stdClass();
      $obj->link = '/admin/'.strtolower($model->model);
      $obj->label = $model->title;
      array_push($links, $obj);
    }
    return $links;
  }

  public static function routes() {

    foreach(Admin::get() as $model) {
      if(!empty($model->middleware)) {
        Route::group(['middleware' => $model->middleware], function () use($model){
          Route::resource('admin/'.strtolower($model->model), '\CRUDController');
        });
      } else {
        Route::resource('admin/'.strtolower($model->model), '\CRUDController');
      }


    }

  }

}