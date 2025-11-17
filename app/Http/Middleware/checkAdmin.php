<?php

namespace App\Http\Middleware;
//use Illuminate\Support\Facades\Cookie;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
//use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Cookie;

//use App\Models\User;
class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

//composer create-project laravel/laravel=10.0^ ikinciel-backend --prefer-dist
//composer create-project laravel/laravel ikinciel-backend 10.0^ --prefer-dist

        //if(Auth::user() == null || Session::get('admin_code') == null){
       // if( ! Auth::guard('admin')->check() ){
       if(empty(Session::get('admin_code')) || empty(Auth::id())){
            Session::forget('admin_code');
            Auth::logout();
            return redirect()->route('admin-login');

        }else{
            // echo Auth::id();
            // echo Session::get('admin_code');
            $data = [
                'role'=> Role::find(auth()->user()->role_id)
            ];

             view()->share(['data'=>$data]);
        }


        return $next($request);
    }
}
