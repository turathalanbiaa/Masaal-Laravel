<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Input;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $currentAdmin = Input::get("currentAdmin");

        if ($permission == "manager")
        {
            if ($currentAdmin->manager == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        if ($permission == "reviewer")
        {
            if ($currentAdmin->reviewer == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        if ($permission == "distributor")
        {
            if ($currentAdmin->distributor == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        if ($permission == "respondent")
        {
            if ($currentAdmin->respondent == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        if ($permission == "post")
        {
            if ($currentAdmin->post == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        if ($permission == "announcement")
        {
            if ($currentAdmin->announcement == 1)
                return $next($request);
            else
                return redirect("/control-panel/$currentAdmin->lang/main")
                    ->with(["permissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم."]);
        }

        return redirect("/control-panel/$currentAdmin->lang/main");
    }
}
