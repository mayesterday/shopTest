<?php

namespace App\Structure\Bills\Conditions;

use App\Helper\ImageDataHelper;
use App\Models\BillDatas;
use App\Models\BillDetailDatas;
use App\Models\customerDatas;
use App\Models\StatusDatas;
use App\Structure\Abstracts\ExAbstracts;
use App\Structure\Abstracts\ExConditionParameterInterface;
use App\Structure\Abstracts\ExResults;

/**
 * ตรวจสอบการ upload slip
 */
class BillCheckSlipCondition extends ExAbstracts
{
  public function process(ExConditionParameterInterface $param): ExResults
  {
    $image_datas = $param->form['image_datas'] ?? null;
    $text = 'ยังไม่อัพหลักฐานการโอนเงิน';
    if ($image_datas) {
      (new ImageDataHelper)->fileUpload($image_datas, $param->bill_data_id, 'bill_datas');
      $text = 'รอเจ้าหน้าที่ตรวจสอบการโอน';
    }
    $findStatus = StatusDatas::where('name', $text)->first();
    BillDatas::findOrFail($param->bill_data_id)->update([
      'status_data_id' => $findStatus->id,
    ]);
    return $this->result;
  }
}
