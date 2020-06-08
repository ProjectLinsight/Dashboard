<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware{
    public function handle($request, Closure $next){
        if(Auth::user()->utype=="Admin")
        return $next($request);
        abort(403);
    }
}