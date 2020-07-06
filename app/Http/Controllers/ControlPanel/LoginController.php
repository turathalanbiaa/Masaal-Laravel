<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /**
     * Login
     *
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        //Redirect to main page
        if (session()->has("MASAEL_CP_ADMIN_REMEMBER_TOKEN"))
            return redirect("/control-panel");

        //Auto login
        if (Cookie::has("MASAEL_CP_ADMIN_REMEMBER_TOKEN"))
        {
            //Find admin
            $admin = Admin::where("remember_token", Cookie::get("MASAEL_CP_ADMIN_REMEMBER_TOKEN"))->first();

            //Admin is not found
            if (!$admin)
            {
                //Remove cookies
                Cookie::queue(cookie()->forget("MASAEL_CP_ADMIN_REMEMBER_TOKEN"));

                return view("control-panel.login");
            }

            //Store last login date
            $admin->last_login_date = date("Y-m-d");
            $admin->save();

            //Make sessions
            session()->put('MASAEL_CP_ADMIN_ID', $admin->id);
            session()->put('MASAEL_CP_ADMIN_NAME', $admin->name);
            session()->put('MASAEL_CP_ADMIN_USERNAME', $admin->username);
            session()->put('MASAEL_CP_ADMIN_TYPE', $admin->type);
            session()->put('MASAEL_CP_ADMIN_LANG', $admin->lang);
            session()->put('MASAEL_CP_ADMIN_LAST_LOGIN_DATE', $admin->last_login_date);
            session()->put('MASAEL_CP_ADMIN_REMEMBER_TOKEN', $admin->remember_token);
            session()->put('MASAEL_CP_PERMISSION', array(
                    "manager"      => $admin->permission->manager,
                    "distributor"  => $admin->permission->distributor,
                    "respondent"   => $admin->permission->respondent,
                    "reviewer"     => $admin->permission->reviewer,
                    "post"         => $admin->permission->post,
                    "announcement" => $admin->permission->announcement,
                    "translator"   => $admin->permission->translator)
            );
            session()->save();

            return redirect("/control-panel");
        }

        return view("control-panel.login");
    }

    /**
     * Login Validation
     *
     * @param Request $request
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginValidation(Request $request)
    {
        //Validation
        $this->validate($request, [
            "username" => "required",
            "password" => "required"
        ], []);

        //Find admin
        $admin = Admin::where("username", Input::get("username"))
            ->where("password", md5(Input::get("password")))
            ->first();

        if (!$admin)
            return redirect("/control-panel/login")->with([
                'ErrorLoginMessage' => "login failed, Try again."
            ]);

        //Store login for multi devises
        if (is_null($admin->remember_token))
            $admin->remember_token = md5(uniqid());

        //Store last login date
        $admin->last_login_date = date("Y-m-d");

        $admin->save();

        //Make sessions
        session()->put('MASAEL_CP_ADMIN_ID', $admin->id);
        session()->put('MASAEL_CP_ADMIN_NAME', $admin->name);
        session()->put('MASAEL_CP_ADMIN_USERNAME', $admin->username);
        session()->put('MASAEL_CP_ADMIN_TYPE', $admin->type);
        session()->put('MASAEL_CP_ADMIN_LANG', $admin->lang);
        session()->put('MASAEL_CP_ADMIN_LAST_LOGIN_DATE', $admin->last_login_date);
        session()->put('MASAEL_CP_ADMIN_REMEMBER_TOKEN', $admin->remember_token);
        session()->put('MASAEL_CP_PERMISSION', array(
            "manager"      => $admin->permission->manager,
            "distributor"  => $admin->permission->distributor,
            "respondent"   => $admin->permission->respondent,
            "reviewer"     => $admin->permission->reviewer,
            "post"         => $admin->permission->post,
            "announcement" => $admin->permission->announcement,
            "translator"   => $admin->permission->translator)
        );
        session()->save();

        //Make cookies
        Cookie::queue(cookie()->forever("MASAEL_CP_ADMIN_REMEMBER_TOKEN", $admin->remember_token));

        //Redirect to main page
        return redirect("/control-panel");
    }
}
