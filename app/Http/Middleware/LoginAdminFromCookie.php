<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;

class LoginAdminFromCookie
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
        if ($request->session()->has('ADMIN_SESSION'))
        {
            $admin = $this->getCurrentAdmin($request->session()->get("ADMIN_SESSION"));

            if ($admin)
            {
                $request->merge(["currentAdmin" => $admin]);
                return $next($request);
            }
        }

        if ($request->hasCookie("ADMIN_SESSION"))
        {
            $admin = $this->getCurrentAdmin($request->cookie("ADMIN_SESSION"));

            if ($admin)
            {
                $request->session()->put('ADMIN_SESSION' , $admin->session);
                $request->merge(["currentAdmin" => $admin]);
                return $next($request);
            }
        }

        $lang = $request->route('lang');

        return redirect("/control-panel/$lang/login");
    }

    private function getCurrentAdmin($adminSession)
    {
        return Admin::where("session", $adminSession)->first();
    }
}
