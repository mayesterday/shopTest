<?php

namespace App\Structure\Products\Conditions;

use App\Helper\ImageDataHelper;
use App\Models\ImageDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

class FetchImagesCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $params): ExResults
  {
    if (!$params->request) {
      dd('ดึงข้อมูลรูปต้องใช้ request');
    }

    $imageDatas = ImageDatas::where('ref', $params->product['id'])->get()->toArray();
    if (!$imageDatas) {
      return $this->result;
    }

    $imageDatas = (new ImageDataHelper)->url($params->request, $imageDatas);
    $this->result->addPreview('images', $imageDatas->toArray());
    return $this->result;
  }
}
