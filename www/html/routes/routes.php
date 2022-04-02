<?php
/**
 * This file contains all the routes for the project
 */

declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::setDefaultNamespace('\WJCrypto\Controllers');

SimpleRouter::get('/', 'FrontendController@showLoginPage');

SimpleRouter::post('/dashboard', 'FrontendController@showDashboardPage');
SimpleRouter::get('/dashboard', 'FrontendController@showDashboardPage');

SimpleRouter::get('/withdraw', 'FrontendController@showWithdrawPage');
SimpleRouter::get('/deposit', 'FrontendController@showDepositPage');
SimpleRouter::get('/transfer', 'FrontendController@showTransferPage');

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