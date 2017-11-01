<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:58 PM
 */

namespace App\Http\Controllers;


class PostController extends Controller
{

    public function index($lang)
    {
        return view("$lang.post.posts" , ["posts" => []]);
    }

}