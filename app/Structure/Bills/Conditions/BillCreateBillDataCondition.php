<?php

namespace App\Structure\Bills\Conditions;

use App\Models\BillDatas;
use App\Models\customerDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

class BillCreateBillDataCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $param): ExResults
  {
    $billDatas = BillDatas::create(['customer_data_id' => $param->customer_data_id]);
    $param->bill_data_id = $billDatas->id;
    return $this->result;
  }
}
