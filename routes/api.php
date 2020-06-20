<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API'], static function() {

    Route::group(['prefix' => 'auth'], static function () {
        Route::post('login', 'AuthController@login');
    });

    Route::group(['middleware' => ['auth:api'], ], static function() {

        Route::group(['prefix' => 'auth'], static function () {
            Route::post('logout', 'AuthController@logout');
        });

        Route::resource('user','UserController');
        Route::resource('user-balance','UserBalanceController');
        Route::resource('user-balance-history','UserBalanceHistoryController');
        Route::resource('balance-bank','BalanceBankController');
        Route::resource('balance-bank-history','BalanceBankHistoryController');

        Route::post('top-up','TransactionController@topUp');
        Route::post('transfer','TransactionController@transfer');
        Route::get('balance-check','TransactionController@balanceCheck');
    });
});


