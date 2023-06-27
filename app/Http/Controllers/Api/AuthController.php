<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{

    // For Register Function ;
    public function register(Request $request){
        //Validation for register

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        //For Fails validator;
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response);
        }

        // For Success validator

        $inputs = $request->all();
        $inputs['password'] = bcrypt($inputs['password']);
        $user = User::create($inputs);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [

            'success' => true,
            'data' => $success,
            'message' => 'User registration successfully',
        ];
        return response()->json($response);

    }

    public function login(Request $request){

        // For Login success;
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            // $success
            /* $user = Auth::user();
                This api fetch not working
                $success['token'] = $user->createToken('MyApp')->plainTextToken; */

            $user = Auth::guard('sanctum')->user();
            $success['name'] = $user;
            $success['token'] = $user->createToken('MyApp')->plainTextToken;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully'
            ];
            return response()->json($response,200);
        }else{

            //For Unauthoried;
            $response = [
                'success' => false,
                'message' => 'Unauthorised'
            ];
            return response()->json($response);
        }
    }




}
