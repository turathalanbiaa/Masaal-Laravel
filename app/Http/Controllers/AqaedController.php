<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\Subject;
class AqaedController extends Controller
{
    public function showRoots($root_id)
    {

        $level=0;
        $subject = Subject::where("root_id", "=", $root_id)->get();

        return view("aqaed.showRoots", ["subject" => $subject, "level" => $level]);

    }
    public function showSubjects($root_id, $level)
    {
        if ($level == 1) {
            $content = Content::where("subject_id", "=", $root_id)->get();
            return view("aqaed.showContent", ["content" => $content]);

        } else {
            $subject = Subject::where("root_id", "=", $root_id)->get();
            return view("aqaed.showRoots", ["subject" => $subject, "level" => $level]);
        }


    }
}
