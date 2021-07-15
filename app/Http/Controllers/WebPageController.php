<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebPageController extends Controller
{
  public function index(Request $request)
  {
    // $website = Cache::remember('miscellaneous_website_corp_logo_shortname_name', 600, function () {
    //   return Miscellaneous::whereIn('name', ['corporation_logo_small', 'corporation_shortname', 'corporation_name'])->pluck('value', 'name');
    // });
    return view('app');
  }
}
