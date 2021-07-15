<?php

namespace App\Structure\Abstracts;

use App\Models\Settings\RoomDatas;

class ExResults
{
  public $preview = [];

  public function addPreview($product, array $datas)
  {
    $this->preview[$product] = $datas;
  }
}
