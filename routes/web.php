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

Route::get('user/addCollection','UserController@addCollection');

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
        Route::get('submitCartQuick','CartController@submitCartQuick');
    }
);

Route::group(
    ['prefix'=>'pay'],
    function(){
        Route::post('aliPay','PayController@aliPay');
        Route::post('aliReturnPay','PayController@aliReturnPay');
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
        Route::any('ajax_shop_item','HomeController@ajax_shop_item');
    }
);

Route::group(
    ['middleware'=>['web', 'auth']],
    function(){
        Route::group(
            ['prefix'=>'user'],
            function(){
                Route::get('info','UserController@info');
                Route::post('addAddress','UserController@addAddress');
                Route::post('updateAddress','UserController@updateAddress');
                Route::get('delAddress','UserController@delAddress');
                Route::get('myGift','UserController@myGift');
                Route::get('myCollection','UserController@myCollection');
                Route::get('myBrowse','UserController@myBrowse');
                Route::post('upload','UserController@imageUpload');
                Route::get('setting','UserController@setting');
                Route::post('editUserInfo','UserController@editUserInfo');
            }
        );
        Route::group(
            ['prefix'=>'order'],
            function(){
                Route::get('cartsubmitquick','OrderController@cartsubmitquick');
                Route::any('add','OrderController@addOrder');
                Route::get('list','OrderController@orderList');
                Route::get('confirmReceipt','OrderController@confirmReceipt');
                Route::any('evaluation','OrderController@evaluation');
                Route::get('cancel','OrderController@cancel');
                Route::post('commentUpload','HomeController@imageUpload');
            }
        );
        Route::group(['prefix'=>'wechat'],function(){
            Route::any('/serve', 'WechatController@serve');
            Route::get('/profile', 'WechatController@profile');
        });
    }
);

