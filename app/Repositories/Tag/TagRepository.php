<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 7:55 AM
 */

namespace App\Repositories\Tag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagRepository
{

    public static function all($lang)
    {
        return Tag::where("lang" , $lang)->select(["id" , "tag"])->orderBy("tag")->get();
    }
}