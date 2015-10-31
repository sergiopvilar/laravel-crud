<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 12:47 AM
 */
class AdminBootstrap {

  public function __construct($path) {

    $folder = realpath(__DIR__.'/../../../../'.$path);
    foreach (glob($folder . "/*.php") as $file) {
      require_once($file);
    }

  }

}
