<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/31/2017
 * Time: 12:07 AM
 */

namespace App\Http\Controllers;


class OtherController extends Controller
{

    public function showApp()
    {
        return view("en.other.app");
    }

}