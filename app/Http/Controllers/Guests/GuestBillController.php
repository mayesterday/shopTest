<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use App\Structure\Abstracts\ExConditions;
use App\Structure\Bills\Abstracts\BillParams;
use App\Structure\Bills\Conditions\BillCalcsBillDataCondition;
use App\Structure\Bills\Conditions\BillCheckSlipCondition;
use App\Structure\Bills\Conditions\BillCreateBillDataCondition;
use App\Structure\Bills\Conditions\BillCreateBillDetailDataCondition;
use App\Structure\Bills\Conditions\BillCreateCustomerCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestBillController extends Controller
{
  public function store(Request $request)
  {


    return DB::transaction(function () use ($request) {
      $paras = new BillParams();
      $paras->addParam($request->toArray());
      $conditions = (new ExConditions)
        ->addCondition(new BillCreateCustomerCondition)
        ->addCondition(new BillCreateBillDataCondition)
        ->addCondition(new BillCreateBillDetailDataCondition)
        ->addCondition(new BillCheckSlipCondition)
        // 
        ->addCondition(new BillCalcsBillDataCondition)
        ->process($paras);
      return response()->api();
    });
  }
}
