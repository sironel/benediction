<?php

namespace App\Http\Middleware;

use Closure;

class Client
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
      if(Auth::check()){

           if (Auth::user()->user_level > 0){
              return $next($request);
           }
           Session::flash('msg', '  vous devez etre Client.');
           return Redirect::back();
       }
       Session::flash('msg', '  vous devez vous connecter.');
           return Redirect::back();
    }
}
