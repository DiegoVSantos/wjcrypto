<?php
/**
 * This file contains all the routes for the project
 */

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use WJCrypto\Controllers\UserController;

SimpleRouter::setDefaultNamespace('\WJCrypto\Controllers');

SimpleRouter::get('/', 'FrontendController@showLoginPage');
SimpleRouter::post('/loginPost', 'UserController@login');
SimpleRouter::get('/logout', 'UserController@logout');

SimpleRouter::post('/', 'UserController@login');

SimpleRouter::get('/register', 'FrontendController@showNewAccPage');
SimpleRouter::post('/register', 'UserController@create');

SimpleRouter::group(['middleware' => WJCrypto\Middlewares\AuthMiddleware::class], function () {
    SimpleRouter::get('/dashboard', 'UserController@getDashboardData');

    SimpleRouter::get('/deposit', 'FrontendController@showDepositPage');
    SimpleRouter::post('/depositPost', 'AccountController@depositController');

    SimpleRouter::get('/withdraw', 'FrontendController@showWithdrawPage');
    SimpleRouter::post('/withdrawPost', 'AccountController@withdrawController');

    SimpleRouter::get('/transfer', 'FrontendController@showTransferPage');
    SimpleRouter::post('/transferPost', 'AccountController@transferController');
});

SimpleRouter::group(['namespace' => 'Api', 'prefix' => '/rest/API'], function() {
    SimpleRouter::post('/register', 'UserApiController@create');
    SimpleRouter::post('/login', 'UserApiController@login');

    SimpleRouter::group(['middleware' => WJCrypto\Middlewares\ApiVerification::class], function () {
        SimpleRouter::post('/accountData', 'AccountApiController@getAccountData');
        SimpleRouter::post('/transactions', 'AccountApiController@transactionHistory');

        SimpleRouter::post('/withdraw', 'AccountApiController@withdrawApi');
        SimpleRouter::post('/deposit', 'AccountApiController@depositApi');
        SimpleRouter::post('/transfer', 'AccountApiController@transferApi');
    });
});

//Router::group(['exceptionHandler' => \Demo\Handlers\CustomExceptionHandler::class], function () {
//
//	Router::get('/', 'DefaultController@home')->setName('home');
//
//	Router::get('/contact', 'DefaultController@contact')->setName('contact');
//
//	Router::basic('/companies/{id?}', 'DefaultController@companies')->setName('companies');
//
//    // API
//
//	Router::group(['prefix' => '/api', 'middleware' => \Demo\Middlewares\ApiVerification::class], function () {
//		Router::resource('/demo', 'ApiController');
//	});
//
//    // CALLBACK EXAMPLES
//
//    Router::get('/foo', function() {
//        return 'foo';
//    });
//
//    Router::get('/foo-bar', function() {
//        return 'foo-bar';
//    });
//
//});