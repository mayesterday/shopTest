<?php

namespace App\Http\Controllers;

use App\Models\CustomerDatas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class LoginController extends Controller
{
  public function loginApplication(Request $request)
  {

    $credentials = ['password' => $request->password];
    if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
      $credentials['email'] = $request->username;
    } elseif (!filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
      $credentials['username'] = $request->username;
    }
    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $token = $user->createToken('token-frontend-admin');
      return response()->api([
        'token' => $token->plainTextToken,
        'name' => $user->name
      ]);
    }
    return response()->api(['Username หรือ รหัสผ่านไม่ถูกต้อง'], true);
  }

  public function register(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string',
    ]);


    $CustomerDatas = CustomerDatas::create([
      'firstname' => $request->firstname,
      'lastname' => $request->lastname,
      'email' => $request->email,
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'customer_data_id' => $CustomerDatas->id,
      'type' => 'customer'
    ]);
  }

  public function logoutOffice(Request $request)
  {
    if ($request->has('all')) {
      return response()->success([
        'logout' => $request->user()->tokens()->delete(),
      ]);
    }
    return response()->success([
      'logout' => $request->user()->currentAccessToken()->delete(),
    ]);
  }

  public function info(Request $request)
  {
    return response()->success($request->user());
  }
}
