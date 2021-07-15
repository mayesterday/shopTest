<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\CategoryDatas;
use Illuminate\Http\Request;

class AdminCategoryDataController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $result = CategoryDatas::get();
    return response()->api($result);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    CategoryDatas::updateOrCreate(['id' => $request->id], [
      'category_name' => $request->category_name,
      'promote' => $request->promote,
    ]);
    return response()->api();
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

    CategoryDatas::updateOrCreate(['id' => $id], [
      'category_name' => $request->category_name,
      'promote' => $request->promote,
    ]);
    return response()->api();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    CategoryDatas::findOrFail($id)->delete();
    return response()->api();
  }
}
