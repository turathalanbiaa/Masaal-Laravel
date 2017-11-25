<?php

namespace App\Repositories\Post;

use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/21/17
 * Time: 9:51 AM
 */

class PostRepository
{
    public static function getRecentPosts($lang , $type , $limit , $offset)
    {
        $SQL = "SELECT id , title , content , lang , time , image
                FROM post
                WHERE lang = ? AND type = ?
                ORDER BY ID DESC LIMIT $limit OFFSET $offset";

        return DB::select($SQL , [$lang , $type]);
    }
}