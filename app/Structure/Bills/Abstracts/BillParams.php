<?php

namespace App\Structure\Bills\Abstracts;

use App\Structure\Abstracts\ExConditionParameterInterface;

class BillParams implements ExConditionParameterInterface
{
  public $form;
  // BillCreateCustomerCondition
  public $customer_data_id;
  public $bill_data_id;

  public function addParam(array $param)
  {
    $this->form = $param;
  }
}
