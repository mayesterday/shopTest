<?php

namespace App\Http\Controllers\Guests;

use App\Helper\ImageDataHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductDatas;
use App\Structure\Abstracts\ExConditions;
use App\Structure\Products\Abstracts\ProductParams;
use App\Structure\Products\Conditions\FetchCategoryCondition;
use App\Structure\Products\Conditions\FetchCategoryNameCondition;
use App\Structure\Products\Conditions\FetchImagesCondition;
use APP\Structure\Products\ProductProcessStructure;
use Faker\Factory;
use Illuminate\Http\Request;

class GuestProductController extends Controller
{
  public function RecommendedProduct(Request $request)
  {
    $products = ProductDatas::with('imageDatas:ref,filename')
      ->with(['ProductCategoryDatas' => function ($productCategory) {
        return $productCategory->with('categoryData:id,category_name');
      }])
      ->orderBy('promote', 'DESC')
      ->orderBy('total_sale', 'DESC')
      ->limit(8)
      ->get()
      ->map(function ($product) use ($request) {
        $_return = $product->toArray();
        $_return['product_category_datas'] = $product->ProductCategoryDatas->reduce(function ($current, $category) {
          $category_name = $category->categoryData->category_name;
          if ($current) {
            return $current .= "& $category_name";
          } else {
            return $current = $category_name;
          }
        }, "");
        $_return['image_datas'] = (new ImageDataHelper)->url($request, $product->imageDatas->toArray());
        return $_return;
      })
      ->values();

    return response()->api($products);
  }


  public function findProduct(Request $request)
  {
    $product_data_id = $request->product_data_id;
    $params = new ProductParams();
    $params->addProduct(ProductDatas::find($product_data_id)->toArray());
    $params->addRules('category', 4); // กำหนเ category ว่าจะเอาตัว ref กี่ตัว
    $params->addRequest($request);

    $result = (new ExConditions)
      ->addCondition((new FetchCategoryNameCondition))
      ->addCondition((new FetchImagesCondition))
      ->addCondition((new FetchCategoryCondition))
      ->process($params);

    return response()->api($result);
  }

  public function countProductClick($product_data_id)
  {
    $product = ProductDatas::find($product_data_id);
    $product->update(
      [
        'total_click' => $product->total_click * 1 + 1
      ]
    );
  }
}
