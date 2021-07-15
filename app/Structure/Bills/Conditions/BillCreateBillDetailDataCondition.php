<?php

namespace App\Structure\Bills\Conditions;

use App\Models\BillDatas;
use App\Models\BillDetailDatas;
use App\Models\customerDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

class BillCreateBillDetailDataCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $param): ExResults
  {
    $products = $param->form['products'];
    $bill_data_id = $param->bill_data_id;
    foreach ($products as $product) {
      $BillDetailDatas = BillDetailDatas::create(
        [
          'bill_data_id' => $bill_data_id,
          'product_data_id' => $product['id'],
          'product_total' => $product['amount'],
          'product_price' => $product['price'],
          'total' => $product['amount'] * $product['price'],
        ]
      );
    }

    return $this->result;
  }
}
