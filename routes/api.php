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


Route::post('/v1/login', 'Api\LoginController@login');
Route::post('/v1/signup', 'Api\LoginController@signup');
  
Route::group(['middleware' => 'auth:api', 'namespace' => 'Api', 'prefix' => 'v1'], function() {
    Route::get('logout', 'LoginController@logout');
    Route::get('user', 'LoginController@user');

    //Companies Route
    Route::get('companies', 'CompanyController@index');
    Route::get('company', 'CompanyController@index');
    Route::post('edit/company', 'CompanyController@edit');
    Route::post('update/company', 'CompanyController@update');
    Route::post('create/company', 'CompanyController@store');
    Route::post('destroy/company', 'CompanyController@destroy');
});
