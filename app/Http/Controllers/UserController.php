<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;
use App\User;

class UserController extends Controller
{
       /**
     * Show the form for creating a new resource.
     * Metoda koja prima JSON sa podacima za registraciju.
	 * Potom validira podatke. Ako validacija prodje kreira korisnika
	 * Ako validacija ne prodje prikazuje gresku
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
		$input_json = $request->getContent();
		$input = json_decode($input_json,true);
		$rules = ['name' => 'required|min:4','email' => 'required|email|unique:users','password' => 'required|min:6'];
		$validator = Validator::make($input,$rules);
		if (!$validator->fails())
		{
			$name = $input['name'];
			$email = $input['email'];
			
			$user = User::create([
			  'name' => $name,
			  'email' => $email,
			  'password' => sha1($input['password']),
			  'api_token' => str_random(60),
			  'account_type' => 'user',
			]);
			
			return response()->json(['token' => $user->api_token],201);
		} else{
			$messages = $validator->messages();
			return response()->json(['error' => $messages],400);
		}
    }
	
	
	public function login(Request $request){
		$input_json = $request->getContent();
		$input = json_decode($input_json,true);
		$rules = ['email' => 'required|email','password' => 'required|min:6'];
		$validator = Validator::make($input,$rules);
		if (!$validator->fails())
		{
			$email = $input['email'];
			$password = sha1($input['password']);
			$user = DB::table('users')->where('email', $email)->where('password',$password)->select(array('api_token'))->first();
			if(isset($user)){
				return response()->json(['token' => $user->api_token]);
			}else{
				return response()->json(['error' => 'Wrong email or password'],401);
			}
		}else{
			$messages = $validator->messages();
			return response()->json(['error' => $messages],400);
		}
	}
	
	public static function getUserByToken($request){
		$token = $request->header("token");
		return DB::table('users')->where('api_token', $token)->select(array('id','name', 'email'))->first();
	}
}
