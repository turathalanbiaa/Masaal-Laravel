<?php

namespace App\Http\Controllers\ControlPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MainController extends Controller
{
    public function index($lang)
    {
        return view("cPanel.$lang.main.main")->with(["lang"=>$lang]);
    }
}
