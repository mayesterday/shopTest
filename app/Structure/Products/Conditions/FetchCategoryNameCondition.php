<?php

namespace App\Structure\Products\Conditions;

use App\Helper\ImageDataHelper;
use App\Models\ImageDatas;
use App\Models\ProductCategoryDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

/**
 * ดึงข้อมูลว่าสินค้านี้อยู่หัวข้อไหน
 */
class FetchCategoryNameCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $params): ExResults
  {
    $query = ProductCategoryDatas::with('categoryData:id,category_name')->where('product_data_id', $params->product['id'])->get()
      ->reduce(function ($current, $category) {
        $category_name = $category->categoryData->category_name;
        if ($current) {
          return $current .= "& $category_name";
        } else {
          return $current = $category_name;
        }
      }, "");




    $this->result->addPreview('category_name', [$query]);
    return $this->result;
  }
}
