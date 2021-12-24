<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;
use DB;
use Validator;
use Session;
use App\Models\Employee;


class EmployeeController extends Controller
{
    use AuthenticatesUsers;
    public function login(request $request){

        $credentials = $request->only('email', 'password');
        dd($credentials);
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}
