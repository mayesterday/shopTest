<?php

namespace App\Http\Controllers\Admins;

use App\Helper\ImageDataHelper;
use App\Http\Controllers\Controller;
use App\Models\BillDatas;
use Illuminate\Http\Request;

class AdminBillDataController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $results = BillDatas::with('customerData', 'imageDatas', 'statusData')
      ->with(['billDetailDatas' => function ($billDetailDatas) {
        $billDetailDatas->with('productData');
      }])
      ->get()
      ->map(function ($billData) use ($request) {
        $_return = $billData->toArray();
        $_return['image_datas'] = (new ImageDataHelper)->url($request, $billData->imageDatas->toArray());
        return $_return;
      });
    return response()->api($results);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
