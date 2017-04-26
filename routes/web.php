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

Route::get('/welcome', 'HomeController@welcome');

Route::get('/', 'HomeController@welcome');

Route::get('/article/{id}', 'ArticlesController@detail');

Route::get('/oauth/github', 'OAuthController@redirectToGitHub');
Route::get('/oauth/github/callback', 'OAuthController@handleGitHubCallback');

Route::get('/oauth/wechat', 'OAuthController@redirectToWechat');
Route::get('/oauth/wechat/callback', 'OAuthController@handleWechatCallback');


Route::get('sendSmsVerify','UserController@sendSMSVerify');
Route::post('bindphone','UserController@bindphone');


Auth::routes();


Route::group(
    [
        'prefix'=>'cart'
    ],
    function(){
        Route::get('add','CartController@addCart');
        Route::get('update','CartController@updateCart');
        Route::get('del','CartController@delCart');
        Route::get('all','CartController@cartAll');
        Route::get('list','CartController@list');
    }
);

Route::group(
    [
        'prefix'=>'gift'
    ],
    function(){
        Route::get('available','GiftcodeController@availableGiftcodes');
        Route::get('receive','GiftcodeController@receiveGiftcode');
    }
);

Route::group(
    ['prefix'=>'shop_item'],
    function(){
        Route::get('detail/{hash_id}','HomeController@detail');
        Route::get('good_list','HomeController@good_list');
        Route::get('ajax_sub_catalog','HomeController@ajax_sub_catalog');
        Route::get('ajax_shop_item','HomeController@ajax_shop_item');
    }
);

Route::group(
    ['middleware'=>['web', 'auth']],
    function(){
        Route::group(
            ['prefix'=>'user'],
            function(){
                Route::get('info','UserController@info');
            }
        );
        Route::group(
            ['prefix'=>'order'],
            function(){
                Route::get('cartsubmitquick','OrderController@cartsubmitquick');
                Route::any('add','OrderController@addOrder');
                Route::get('list','OrderController@orderList');
            }
        );
        Route::group(['prefix'=>'wechat'],function(){
            Route::any('/serve', 'WechatController@serve');
            Route::get('/profile', 'WechatController@profile');
        });
    }
);

