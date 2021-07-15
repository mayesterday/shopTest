<?php

namespace App\Structure\Bills\Conditions;

use App\Models\BillDatas;
use App\Models\BillDetailDatas;
use App\Models\customerDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

class BillCalcsBillDataCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $param): ExResults
  {
    $billDetail = BillDetailDatas::selectRaw("sum(total) as total,sum(product_total) as total_product")
      ->where('bill_data_id', $param->bill_data_id)
      ->first();

    BillDatas::findOrFail($param->bill_data_id)->update([
      'total' => $billDetail->total,
      'total_product' => $billDetail->total_product
    ]);
    return $this->result;
  }
}
