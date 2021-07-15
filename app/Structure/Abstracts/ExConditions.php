<?php

namespace App\Structure\Abstracts;

class ExConditions
{
  public $way = [];
  public $previews = [];
  public $selfs = [];
  // ประเภท action ที่จะกระทำ
  public $action = '';

  public $stateBillLists = [];


  public function addCondition(ExAbstracts $selfs)
  {
    $this->selfs[] = $selfs;
    return $this;
  }

  public function process(ExConditionParameterInterface $params)
  {
    $selfs = $this->selfs;
    foreach ($selfs as $self) {
      $resp = $self->process($params);
      if ($resp->preview) {
        $column_name = array_key_first($resp->preview);
        $this->previews[$column_name] = $resp->preview[$column_name];
      }
    }
    $params->product['previews'] = collect($this->previews);
    return $params->product;
  }

  public function clearPreview()
  {
    $this->preview = [];
  }
}
