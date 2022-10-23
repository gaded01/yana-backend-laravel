<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function loginUser(Request $request)
	{
		$user = User::where("email", $request->email)->first();
		if($user) {
			if(Hash::check($request->password, $user->password)) {
				$token = $user->createToken('api_token')->plainTextToken;
				return response()->json([
					'access_token' => $token,
					'user' => $user,
				]);
			}
			else {
				return response()->json([
					'status' => 'failed',
					'message' => 'Password is invalid',
				]);
			}
		}
		else {
			return response()->json([
				'status' => 'failed',
				'message' => 'Email does not exists.',
			]);
		}
	}

	public function signupUser(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8',
		]);
		if($validator->fails()) {
			$message = $validator->messages();
			return response()->json([
				'messages' => $message,
				'status' => 'failed'
			]);
		}
		$user = User::create([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'middle_name' => $request->middle_name,
			// 'birth_date' => Carbon::parse($request->birth_date),
			'address' => $request->address,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);
		return $user;
	}


	public function signoutUser(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		return [
			'message' => 'token revoked',
		];
	}


}
