<?php

namespace App\Structure\Abstracts;

abstract class ExAbstracts
{
  public $result;
  public function __construct()
  {
    $this->result = new ExResults();
  }
  abstract public function process(ExConditionParameterInterface $params): ExResults;
}
