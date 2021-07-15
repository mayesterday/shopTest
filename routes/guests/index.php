<?php
Route::group(['prefix' => 'guest', 'namespace' => 'App\Http\Controllers\Guests'], function () {
  Route::get('fetchCategory', 'GuestCategoryController@fetchCategory');
  Route::get('fetchCategoryWithProduct/{category_data_id}', 'GuestCategoryController@fetchCategoryWithProduct');
  Route::get('recommendedCategory', 'GuestCategoryController@fetchRecommendedCategory');
  Route::get('category/countproductclick/{category_data_id}', 'GuestCategoryController@countCategoryClick');
  Route::post('bill/store', 'GuestBillController@store');

  Route::get('recommendedProduct', 'GuestProductController@RecommendedProduct');
  Route::post('findproduct', 'GuestProductController@findProduct');
  Route::get('countproductclick/{product_data_id}', 'GuestProductController@countProductClick');

  Route::get('promotions', 'GuestsPromotionDatasController@index');
});
