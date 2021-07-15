<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\LoginController@loginApplication');
Route::post('register', 'App\Http\Controllers\LoginController@register');
require base_path('routes/guests/index.php');




Route::middleware('auth:sanctum')->group(function () {
  Route::group(['prefix' => 'admin', 'namespace' => "App\Http\Controllers\Admins"], function () {
    // Route::get('categorydata/index', 'AdminCategoryDataController@index');
    Route::resource('category', 'AdminCategoryDataController');
    Route::resource('products', 'AdimnProductController');
    Route::resource('billdata', 'AdminBillDataController');
    Route::resource('Promotion', 'PromotionDatasController');
  });
});
