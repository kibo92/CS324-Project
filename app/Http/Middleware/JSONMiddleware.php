<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class JSONMiddleware
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
		$input_json = $request->getContent();
		$input = json_decode($input_json,true);
		if(!isset($input)){
			return response()->json(['error' => "JSON not valid"],400);
		}

        return $next($request);
    }

}