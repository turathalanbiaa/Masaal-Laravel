<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:58 PM
 */

namespace App\Http\Controllers;


use App\Models\Post;

class PostController extends Controller
{

    public function index($lang , $type)
    {

        $posts = Post::where("lang" ,$lang)->where("type" ,$type)->get();

        return view("$lang.post.posts" , ["posts" => [$posts]]);
    }

}