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

Route::get('/home', 'HomeController@index');

Route::get('/', 'HomeController@index');

Route::get('/article/{id}', 'ArticlesController@detail');

Route::get('/oauth/github', 'OAuthController@redirectToGitHub');
Route::get('/oauth/github/callback', 'OAuthController@handleGitHubCallback');

Auth::routes();


Route::group(['middleware'=>'auth'],function (){

});
