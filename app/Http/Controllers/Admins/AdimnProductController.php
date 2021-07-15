<?php

namespace App\Http\Controllers\Admins;

use App\Helper\ImageDataHelper;
use App\Http\Controllers\Controller;
use App\Models\ImageDatas;
use App\Models\ProductCategoryDatas;
use App\Models\ProductDatas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdimnProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $result = ProductDatas::with('ProductCategoryDatas', 'imageDatas')
      ->get()
      ->map(function ($product) use ($request) {
        $_return = $product->toArray();
        $_return['image_datas'] = (new ImageDataHelper)->url($request, $product->imageDatas->toArray());
        return $_return;
      })->values();
    return response()->api($result);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    return DB::transaction(function () use ($request) {
      $ProductDatas = ProductDatas::updateOrCreate(['id' => $request->id], $request->toArray());
      $product_category_datas = $request->product_category_datas;

      (new ImageDataHelper)->fileUpload($request->images_datas, $ProductDatas->id, 'product_datas');

      foreach ($product_category_datas as $category_data_id) {
        $ProductCategoryDatas = ProductCategoryDatas::create([
          'product_data_id' => $ProductDatas->id,
          'category_data_id' => $category_data_id
        ]);
      }

      return response()->api([]);
    });
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    return DB::transaction(function () use ($request) {

      $ProductDatas = ProductDatas::updateOrCreate(['id' => $request->id], $request->toArray());
      // dd($request->image_datas);
      // (new ImageDataHelper)->fileUpload($request->images_datas, $ProductDatas->id, 'product_datas');

      ProductCategoryDatas::where('product_data_id', $request->id)->delete();
      $product_category_datas = $request->product_category_datas;
      foreach ($product_category_datas as $category_data_id) {
        $ProductCategoryDatas = ProductCategoryDatas::create([
          'product_data_id' => $ProductDatas->id,
          'category_data_id' => $category_data_id
        ]);
      }
      return response()->api([]);
    });
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    ProductCategoryDatas::where('product_data_id', $id)->delete();
    ProductDatas::find($id)->delete();
    return response()->api();
  }
}
