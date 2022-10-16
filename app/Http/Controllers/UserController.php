<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        $user = User::where('name', $request->name)->first();
        if($user){
            $birhdate = User::where('birthdate', $request->birthdate)->first();
            if($birhdate){
                $token = $user->createToken('api_token')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'user' => $user,
                ]);
            }
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email does not exist.',
            ]);
        }
    }

    public function signupUser(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        if($validator->fails()){
            $message = $validator->messages();
            return response()->json([
                'messages' => $message,
                'status' => 'failed'
            ]);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => Carbon::parse($request->birth_date),
            'address' => $request->address,
        ]);
        
        return $user;
    }

}
