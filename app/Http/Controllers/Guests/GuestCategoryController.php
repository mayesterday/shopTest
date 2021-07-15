<?php

namespace App\Http\Controllers\Guests;

use App\Helper\ImageDataHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryDatas;
use App\Models\ProductCategoryDatas;
use App\Models\ProductDatas;
use App\Structure\Abstracts\ExConditions;
use App\Structure\Products\Abstracts\ProductParams;
use App\Structure\Products\Conditions\FetchCategoryNameCondition;
use App\Structure\Products\Conditions\FetchImagesCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestCategoryController extends Controller
{
  /**
   * ดึงรายการหัวข้อไปแสดง
   */
  public function fetchCategory()
  {
    $categoryDatas = CategoryDatas::get();
    return response()->api($categoryDatas);
  }

  public function countCategoryClick($category_data_id)
  {
    $category = CategoryDatas::find($category_data_id);
    $category->update(
      [
        'count_click'  => $category->count_click * 1 + 1
      ]
    );
  }

  public function fetchRecommendedCategory()
  {
    $recommendCategory = ProductCategoryDatas::addSelect(
      [
        'total_click' => ProductDatas::selectRaw('total_click')
          ->whereColumn('product_data_id', 'product_datas.id')
          ->orderBy('total_click', 'desc')
          ->take(1),
        'p_id' => ProductDatas::selectRaw('id')
          ->whereColumn('product_data_id', 'product_datas.id')
          ->orderBy('total_click', 'desc')
          ->take(1),
      ]
    )
      ->orderBy('total_click', 'desc')
      ->limit(6)
      ->groupBy('category_data_id')
      // 
      ->get();
    dd($recommendCategory->toArray());
  }

  public function fetchRecommendedCategory1()
  {
    $recommendCategory = CategoryDatas::with(['ProductCategoryDatas' => function ($productCategoryDatas) {
      $productCategoryDatas->with(['productData' => function ($productDatas) {
        $productDatas->orderBy('total_sale', 'desc');
      }]);
    }])
      // 
      ->orderBy('promote', 'desc')->limit(3)->get();
    dd($recommendCategory->toArray());
  }

  /**
   * ดึงหัวข้อละสิ้นค้า
   */
  public function fetchCategoryWithProduct(Request $request, $category_data_id)
  {
    // $category_data_id = $request->category_data_id;
    $ProductDatas = ProductDatas::whereHas('ProductCategoryDatas', function ($ProductCategoryData) use ($category_data_id) {
      $ProductCategoryData->where('category_data_id', $category_data_id);
    })
      ->get();

    $params = new ProductParams();
    $params->addRequest($request);
    $condition = new ExConditions();
    $condition
      ->addCondition((new FetchCategoryNameCondition))
      ->addCondition((new FetchImagesCondition));

    $_returns = [];

    foreach ($ProductDatas as $product) {
      $params->addProduct($product->toArray());
      $_returns[] = $condition->process($params);
      $condition->clearPreview();
    }

    return response()->api($_returns);
  }

  public function showCategoryWithProduct($category_data_id)
  {
    $categoryDatas = CategoryDatas::find('category_data_id', $category_data_id)->get();
    return response()->api($categoryDatas);
  }
}
