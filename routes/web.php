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

Route::get('/hello', function () {
    return "hello world";
});

#to return a parameter in the url we can do the following
// Route::get('/users/{id}/{name}', function($id, $name) {
//     return "this is the $name $id";
// });

Route::get('/about', 'PagesController@about');

Route::get('/', 'PagesController@index');

Route::get('/services', 'PagesController@services');

//so we dont have to create every single route by hand, we can use this shortcut

Route::resource('posts', 'PostsController');

//Using the above route doesnt work for some reason for the form

Route::post('/posts/store', 'PostsController@store');