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

        if (($permission == "manager") && ($currentAdmin->manager == 1))
            return $next($request);
        elseif (($permission == "reviewer") && ($currentAdmin->reviewer == 1))
            return $next($request);
        elseif (($permission == "distributor") && ($currentAdmin->distributor == 1))
            return $next($request);
        elseif (($permission == "respondent") && ($currentAdmin->respondent == 1))
            return $next($request);
        elseif (($permission == "post") && ($currentAdmin->post == 1))
            return $next($request);
        elseif (($permission == "announcement") && ($currentAdmin->announcement == 1))
            return $next($request);

        return redirect("/control-panel/$currentAdmin->lang/main")->with([
            "ArPermissionMessage", "عذراً، لايمكنك الوصول الى هذا القسم.",
            "EnPermissionMessage", "Sorry, you can not access this section.",
            "FrPermissionMessage", "Désolé, vous ne pouvez pas accéder à cette section.",
        ]);
    }
}
