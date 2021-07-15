<?php

namespace App\Structure\Products\Conditions;

use App\Models\ImageDatas;
use App\Models\ProductCategoryDatas;
use App\Models\ProductDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExConditions;
use App\Structure\Abstracts\ExResults;
use App\Structure\Products\Abstracts\ProductParams;

/**
 * ดึงรายการสินค้าที่อยู่หมวดเดียวกันกับ สินค้าที่เลือกมาทั้งหมด
 */
class FetchCategoryCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $params): ExResults
  {
    $result = ProductCategoryDatas::where('product_data_id', $params->product['id'])->first();
    $result = ProductDatas::whereHas('ProductCategoryDatas', function ($ProductCategoryData) use ($result) {
      $ProductCategoryData->where('category_data_id', $result->category_data_id);
    })
      ->where('id', '!=', $params->product['id']);

    /**
     * ไม่มีข้อมูลสิ้นค้าของหัวข้อที่เกี่ยวข้อง
     */
    if (!$result) {
      $this->result->addPreview('category_ref', []);
      return $this->result;
    }

    /**
     * ตรวจสอบว่าได้ตั้ง กฏ มาหรือไม่
     */
    if (isset($params->rules['category'])) {
      $result = $result->limit($params->rules['category']);
    }

    $result = $result->get();


    /**
     * สร้าง group ดึงข้อมูลรูปของสิ้นค้าที่เกี่ยวข้อง
     */
    $products = [];
    $_param  = new ProductParams();
    $conditions = new ExConditions();
    $conditions->addCondition((new FetchImagesCondition))
      ->addCondition((new FetchCategoryNameCondition));
    $_param->addRequest($params->request);

    foreach ($result as $product) {
      $_param->addProduct($product->toArray());
      $products[] = $conditions->process($_param);
      $conditions->clearPreview();
    }

    $this->result->addPreview('category_ref', $products);

    return $this->result;
  }
}
