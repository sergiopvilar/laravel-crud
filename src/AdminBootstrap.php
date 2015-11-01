<?php

/**
 * Created by PhpStorm.
 * User: sergiovilar
 * Date: 9/23/15
 * Time: 12:47 AM
 */
class AdminBootstrap {

  public function __construct($path, $app = false) {

    if($app) {
      $app->register('Collective\Html\HtmlServiceProvider');
      class_alias('Collective\Html\FormFacade', 'Form');
      class_alias('Collective\Html\HtmlFacade', 'Html');
      class_alias('Laravel\Lumen\Routing\UrlGenerator', 'Illuminate\Routing\UrlGenerator');
    }

    $folder = realpath(__DIR__.'/../../../../'.$path);
    foreach (glob($folder . "/*.php") as $file) {
      require_once($file);
    }

  }

}
