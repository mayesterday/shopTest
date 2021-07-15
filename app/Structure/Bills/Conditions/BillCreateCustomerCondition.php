<?php

namespace App\Structure\Bills\Conditions;

use App\Models\CustomerDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

class BillCreateCustomerCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $param): ExResults
  {
    $data = $param->form['customer'];

    $customerData = CustomerDatas::updateOrCreate(
      [
        'firstname' => $data['firstname'],
        'lastname' => $data['lastname'],
      ],
      $data
    );
    $param->customer_data_id = $customerData->id;
    return $this->result;
  }
}
