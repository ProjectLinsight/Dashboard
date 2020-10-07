<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class StudentMiddleware{
    public function handle($request, Closure $next){
        $user = Auth::user();
        $hasher = app('hash');
        if(Auth::user()->utype=="Student"){
            if(!($hasher->check('12345678', $user->password))){
                return $next($request);
            }else{
                return  redirect()->to('password/reset');
            }
        }else{
            abort(403);
        }
    }
}
