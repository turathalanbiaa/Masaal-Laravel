<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
//    public function addTags()
//    {
//
//        $sub = "";
//        $tags = explode(",", $sub);
//
//        foreach ($tags as $tag) {
//            $newTag = new Tag();
//            $newTag->lang = "fr";
//            $newTag->tag = $tag;
//            $newTag->save();
//        }
//    }

    public function tags($lang)
    {
        $tags = Tag::where("lang", $lang)->orderBy('tag', 'ASC')->get();

        return view("$lang.Question.q_a", ["tags" => $tags]);
    }



}
