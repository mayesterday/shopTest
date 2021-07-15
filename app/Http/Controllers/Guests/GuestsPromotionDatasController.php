<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use App\Models\PromotionDatas;
use Illuminate\Http\Request;

class GuestsPromotionDatasController extends Controller
{
  public function index()
  {
    $promotions = PromotionDatas::get();
    return response()->api($promotions);
  }
}
