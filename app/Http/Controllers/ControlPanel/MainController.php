<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

class MainController extends Controller
{
    /**
     * Main page for Control Panel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::check();
        $lang = AdminController::getLang();
        return view("control-panel.$lang.main");
    }


    public function logout()
    {
        Auth::check();
        $admin = Admin::findOrFail(AdminController::getId());

        //logout from all devices
        if (Input::get("device") == "all")
            $admin->remember_token = null;
        $admin->save();

        //Remove session
        session()->remove("MASAEL_CP_ADMIN_ID");
        session()->remove("MASAEL_CP_ADMIN_NAME");
        session()->remove("MASAEL_CP_ADMIN_USERNAME");
        session()->remove("MASAEL_CP_ADMIN_TYPE");
        session()->remove("MASAEL_CP_ADMIN_LANG");
        session()->remove("MASAEL_CP_ADMIN_LAST_LOGIN_DATE");
        session()->remove("MASAEL_CP_ADMIN_REMEMBER_TOKEN");
        session()->remove("MASAEL_CP_PERMISSION");
        session()->save();

        //Remove cookie
        Cookie::queue(cookie()->forget("MASAEL_CP_ADMIN_REMEMBER_TOKEN"));

        //Redirect to login page
        if (Input::get("device") == "all")
            return redirect("/control-panel/login")->with([
                "LogoutMessage" => "Logout From All Devices."
            ]);
        else
            return redirect("/control-panel/login")->with([
                "LogoutMessage" => "Logout From Current Device."
            ]);
    }
}
