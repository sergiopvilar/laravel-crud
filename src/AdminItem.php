<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 12:41 AM
 */
class AdminItem {

  public $model;
  public $title;
  public $column = [];
  public $form = [];
  public $middleware = [];
  public $storage = 'local';

  public function __construct($model) {
    $this->model = $model;
  }

  public function middleware($mid) {
    $this->middleware = $mid;
    return $this;
  }

  public function storage($storage) {
    $this->storage = $storage;
  }

  public function title($title) {
    $this->title = $title;
    return $this;
  }

  public function columns($cb) {
    Column::reset();
    call_user_func($cb);
    $this->column = Column::get();
    return $this;
  }

  public function form($cb) {
    FormItem::reset();
    call_user_func($cb);
    $this->form = FormItem::get();
    return $this;
  }

}
