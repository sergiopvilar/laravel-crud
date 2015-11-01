# laravel-crud

Create CRUDs (Create, Read, Update, Delete) for your models in Laravel 5 and Lumen.

## Installation

Install via composer:

    composer require sergiovilar/laravel-crud

Add this line to the `bootstrap/app.php` file before the `return $app;`:

    new AdminBootstrap('/app/Admin');

*Note:* In Lumen framework you should put this piece of code above before the `$app->group(['namespace' => 'App\Http\Controllers'])`.

`/app/Admin` should be the folder where you'll put the CRUDs specification.

Add this line to your `app/http/routes.php` file:

    Admin::routes();

Copy the contents of the `views` folder to `resources/views`.

## Usage

Create a file with the name of the model you want to create the CRUD:

    touch app/Admin/Car.php

Car.php:

    Admin::model('Car')
    ->middleware('admin') // Specify an HTTP Middleware to check if the user is logged
    ->title('Cars') // Title of the page
    ->columns(function(){ // Columns to list the items in this model
        Column::string('model', 'Model'); // field, label
        Column::integer('year', 'Year');
    })->form(function(){
        FormItem::text('model', 'Model'); // field, label
        FormItem::number('year', 'Year');
    });
