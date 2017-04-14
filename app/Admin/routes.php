<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->get('giftcode/download','GiftcodeController@download');

    $router->get('giftcode/clearNotUse','GiftcodeController@clearNotUse');

    $router->resource('catalog', CatalogsController::class);

    $router->resource('article', ArticlesController::class);

    $router->resource('page', PagesController::class);

    $router->resource('shopitem', ShopItemController::class);

    $router->resource('giftcode', GiftcodeController::class);


    $router->get('updateSite', 'HomeController@updateSite');


});
