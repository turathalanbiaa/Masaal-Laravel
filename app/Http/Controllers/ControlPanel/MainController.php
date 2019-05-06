<?php

namespace App\Http\Controllers\ControlPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * Main page for Control Panel
     *
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($lang)
    {
        return view("cPanel.$lang.main.main")->with(["lang"=>$lang]);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request, $lang)
    {
        $request->session()->remove("ADMIN_SESSION");
        return redirect("/control-panel/$lang/")
            ->cookie("ADMIN_SESSION", null, -1);
    }
}
