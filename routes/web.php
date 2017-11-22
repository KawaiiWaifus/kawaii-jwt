<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
{
    // implement your reset password route here!
}]);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/*
\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
});
*/
