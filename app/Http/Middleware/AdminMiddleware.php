<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class AdminMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$token = $request->header('token');
        if (!isset($token)) {
            return response()->json(['error' => 'Not authorized'],401);
        }
		
		$user = DB::table('users')->where('api_token', $token)->first();
		
		if(sizeof($user) != 1){
			return response()->json(['error' => 'Not authorized'],401);
		}
		
		if($user->account_type != "admin"){
			return response()->json(['error' => 'Not authorized'],401);
		}
        return $next($request);
    }

}