<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class TokenMiddleware
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
		
		$user = DB::table('users')->where('api_token', $token)->get();
		
		if(sizeof($user) != 1){
			return response()->json(['error' => 'Not authorized'],401);
		}

        return $next($request);
    }

}