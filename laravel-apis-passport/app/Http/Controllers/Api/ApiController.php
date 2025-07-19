<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // register Api[name ,email ,profile_image ,password ,password_confirmation]
    public function register(Request $request){
        
        $data= request()->validate([
            'name'=>'required|string|max:255|min:3',
            'email'=>'required|email|unique:users,email',
            'profile_image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'=>'required|min:6|confirmed',
        ]);
        if($request->hasFile('profile_image')){
            $data['profile_image']=$request->file('profile_image')->store('users','public');
        }
    User::create($data);
        return response()->json([
            'status'=>true,
            'message'=>'User Created Successfully',
            'data'=>$data,
        ],201);

    }

    //login Api [email ,password]
    public function login(){
            $data= request()->validate([
                'email'=>'required|email',
                'password'=>'required|min:6',
            ]);
            $user= User::where('email',$data['email'])->first();
            if(!empty($user)){
                if(Hash::check($data['password'],$user->password)){
                    $token= $user->createToken("MyToken")->accessToken;
                    return response()->json([
                        'status'=>true,
                        'message'=>'User Login Successfully',
                        'data'=>[
                            'user'=>$user,
                            'token'=>$token,
                        ],
                    ],200);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Password is Incorrect',
                    ],401);
                }
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'User Not Found',
                ],404);
            }
    }

//profile Api 
public function profile(){
        $userdate= auth()->user();
        return response()->json([
            'status'=>true,
            'message'=>'User Profile',
            'data'=>$userdate,
            'profile_image'=>url('storage/'.$userdate['profile_image']),
        ],200);
    } 

    //refresh token Api 
    public function refreshToken(){
        auth()->user()->token()->revoke();
        $user= auth()->user();
        $token= $user->createToken("myToken")->accessToken;
        return response()->json([
            'status'=>true,
            'message'=>'Token Refreshed Successfully',
            'data'=>[
                'user'=>$user,
                'token'=>$token,
            ],
        ],200);
    
    }

    //logout Api [email ,password]
    public function logout(){
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully'], 200);

    }
}

