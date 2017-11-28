<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/28/17
 * Time: 2:34 PM
 */

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class LoginFromCookie
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->session()->has('USER_ID'))
            return $next($request);

        $cookie = $request->cookie('SESSION' , null);

        if ($cookie)
        {
            $user = User::where("session" , $cookie)->first();
            if ($user)
            {
                $request->session()->put('USER_ID' , $user->id);
            }
        }

        return $next($request);
    }

}