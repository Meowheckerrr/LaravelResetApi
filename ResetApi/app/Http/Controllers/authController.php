<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response; //create customer response
use Illuminate\Support\Facades\Hash; //crypt 


class authController extends Controller
{


    // create user and generate the token 
    public function register(Request $request){

        //validation
        $fields = $request->validate([

            'name' => ['required', 'min:3'],
            'email'=> 'required|string|unique:users,email',
            'password'=>'required|confirmed|min:6'

        ]);
        //user model create and pass in 
        $user =User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password'])
        ]);

        //generate token 
        $token = $user->createToken('meowheckerToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        //201 which mean something's successful and something was cretaed
        return response($response,201);

    }

    public function login(Request $request){

        //validation
        $fields = $request->validate([

            'email'=> 'required|string',
            'password'=>'required|string'

        ]);
        // check email
        $user = User::where('email',$fields['email'])->first();

        //check hash passowrd
        if(!$user || !Hash::check($fields['password'],$user->password)){

            return response([
                'message' => 'email or password error'
            ],401);
        }

        //generate token 
        $token = $user->createToken('meowheckerToken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        //201 which mean something's successful and something was cretaed
        return response($response,201);

    }


    //logout and delete the token 
    public function logout(Request $request){
        //tokens() is not error  
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
