<?php

namespace App\Http\Middleware;

use Closure;
use App\User ;

class CheckCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = User::find(Auth::user()->id);
        $enrolled = DB::table('stu_enrollments')->where('index',$user->index)->get();
        return $next($request);
    }
}
