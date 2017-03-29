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

Route::get('/shopItem/detail/{has_id}','HomeController@detail');


Auth::routes();


Route::group(
//    ['middleware'=>['web', 'wechat.oauth']],
    ['middleware'=>['web', 'auth']],
    function (){

        Route::group(['prefix'=>'wechat'],function(){
            Route::any('/serve', 'WechatController@serve');
            Route::get('/profile', 'WechatController@profile');

        });
    }
);



Route::get('cart/add','CartController@addCart');

Route::get('good_list','HomeController@good_list');
