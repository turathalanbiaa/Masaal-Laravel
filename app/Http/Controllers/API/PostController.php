<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/21/17
 * Time: 9:49 AM
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;

use App\Repositories\Post\PostRepository;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{

    public function recentPosts()
    {
        sleep(2);
        $limit = 5;
        $offset = Input::get("offset" , 0);
        $lang = Input::get("lang" , "ar");
        $type = Input::get("type" , 1);
        $posts = PostRepository::getRecentPosts($lang , $type , $limit , $offset);
        return $posts;
    }

}