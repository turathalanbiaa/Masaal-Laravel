<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;

class Auth extends Controller
{
    /**
     * Check Auth
     */
    public static function check()
    {
        self::isLoggedIn();
        self::hasPermission();
    }

    /**
     * Check account is logged in or not.
     */
    private static function isLoggedIn()
    {
        if (!session()->has("MASAEL_CP_ADMIN_REMEMBER_TOKEN"))
            abort(302, '', ['Location' => "/control-panel/login"]);
    }

    /**
     * Check account permission
     */
    private static function hasPermission()
    {
        $permission = session()->get("MASAEL_CP_PERMISSION");

        if (request()->is("control-panel/admins*") && ($permission["manager"] != 1))
            abort("404");

        if (request()->is("control-panel/distributor*") && ($permission["distributor"] != 1))
            abort("404");

        if (request()->is("control-panel/respondent*") && ($permission["respondent"] != 1))
            abort("404");

        if (request()->is("control-panel/reviewer*") && ($permission["reviewer"] != 1))
            abort("404");

        if (request()->is("control-panel/posts*") && ($permission["post"] != 1))
            abort("404");

        if (request()->is("control-panel/announcements*") && ($permission["announcement"] != 1))
            abort("404");

        if (request()->is("control-panel/categories*") && ($permission["manager"] != 1))
            abort("404");
    }
}
