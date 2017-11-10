<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 7:55 AM
 */

namespace App\Repositories\Question;
use Illuminate\Support\Facades\DB;

class QuestionRepository
{

    public static function getRecentQuestions($lang , $limit , $offset)
    {
        $SQL = "SELECT question.id , content , user.name AS userDisplayName , category.category AS category , time , answer , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? 
                ORDER BY ID DESC LIMIT $limit OFFSET $offset";

        return DB::select($SQL , [$lang]);
    }
}