<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
class AdminMiddleware
{
    public function handle($request, Closure $next){
        if($request->user()->is_admin){
            return $next($request);
        }

        return response()->json(['error' => "Unauthorized"],403);
    }

}
