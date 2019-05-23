<?php

namespace App\Http\Controllers\ControlPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $lang = session()->get("MASAEL_CP_ADMIN_LANG");
        return view("control-panel.$lang.main");
    }


    public function logout(Request $request)
    {
        return "Logout";
    }
}
