<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class LecturerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next){
        if(Auth::user()->utype=="Lecturer")
        return $next($request);
        abort(403);
    }
}
