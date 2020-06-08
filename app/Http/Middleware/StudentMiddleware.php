<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class StudentMiddleware{
    public function handle($request, Closure $next){
        if(Auth::user()->utype=="Student")
        return $next($request);
        abort(403);
    }
}