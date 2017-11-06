<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 7:55 AM
 */

namespace App\Repositories\Question;

use App\Models\Question;

class QuestionRepository
{

    public static function getRecentQuestions($limit , $offset)
    {
        return Question::orderBy("id" , "DESC")->limit($limit)->offset($offset)->get();
    }
}