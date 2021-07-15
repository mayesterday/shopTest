<?php

namespace App\Structure\Products\Abstracts;

use App\Structure\Abstracts\ExConditionParameterInterface;
use Illuminate\Http\Request;

class ProductParams implements ExConditionParameterInterface
{
  public $product = [];
  public $request = ''; // กรณี สร้าง image
  public $rules = []; //กฏการ query ต่างๆ
  public function addProduct(array $product)
  {
    $this->product = $product;
  }
  /**
   * ใช้ในกรณีสร้าง image
   */
  public function addRequest(Request $request)
  {
    $this->request = $request;
  }

  public function addRules($condition_name, $condition)
  {
    $this->rules[$condition_name] = $condition;
  }
}
