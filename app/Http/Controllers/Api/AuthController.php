<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
                $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']) ,
        ]);
        $accessToken = $user->createToken('authToken')->accessToken;
      
        return response([ 'user' => $user, 'access_token' => $accessToken]);
      }
      
      public function login(Request $request) {
        $data = $request->all();
        $loginData = [
          'email' => $data['email'],
          'password' => $data['password']
        ];
        
        if (!auth()->attempt($loginData)) {
          return response(['message' => 'Invalid Credentials']);
        }
       
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
      }
      
      public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
          'message' => 'Successfully logged out'
        ]);
      }
      
      public function user(Request $request) {
        return response()->json($request->user());
      }
      
}
