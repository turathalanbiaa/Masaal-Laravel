<?php

namespace App\Http\Controllers\API;

use App\Content;
use App\Http\Controllers\Controller;
use App\Subject;

class AqaedController extends Controller
{
    public function getContent($subject_id)
    {
        $content = Content::where("subject_id", "=", $subject_id)->get()->toJson(JSON_UNESCAPED_UNICODE);
        return $content;
    }

    public function getSubject($id)
    {

        if( $obj_subject = Subject::find($id))
        {

            $obj_subject->downloads = $obj_subject->downloads + 1;
            $obj_subject->save();
        }


        $subject = Subject::where("root_id", "=", $id)->get()->toJson(JSON_UNESCAPED_UNICODE);
        return $subject;
    }
}
