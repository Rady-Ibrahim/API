<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    public function register(Request $request){
        $data = $request -> validate([
            'name' => 'required|string|max:255, min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $userdata = User::create($data);
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $userdata,
        ], 201);
    }

    public function login(Request $request){
        $data= $request -> validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            $token = auth()->attempt($data);

            if(!$token){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }else{
                //$user = auth()->user();
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'data' => [
                        //'user' => $user,
                        'token' => $token,
                    ],
                ], 200);
            }
    }

    public function profile(Request $request){
        $userdata = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'User profile',
            'data' => $userdata,
        ], 200);
    }

    public function refreshToken(Request $request){
        $token = auth()->refresh();
        return response()->json([
            'status' => true,
            'message' => 'Token refreshed successfully',
            'data' => [
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request){
        auth()->logout();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }


}




