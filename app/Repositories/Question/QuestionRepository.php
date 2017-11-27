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

    public static function getRecentQuestions($lang ,  $type , $limit , $offset)
    {
        $SQL = "SELECT question.id , content , user.name AS userDisplayName , category.category AS category , time , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? AND question.type = ? 
                ORDER BY ID DESC LIMIT $limit OFFSET $offset";

        return DB::select($SQL , [$lang , $type]);
    }

    public static function search($lang , $text , $category)
    {
        $params = [$lang];
        if (isset($category) && !empty(trim($category)))
        {
            $categoryCondition = " AND category.category = ? ";
            $params[] = trim($category);
        }
        else
        {
            $categoryCondition = "";
        }

        if (isset($text) && !empty(trim($text)))
        {
            $textCondition = " AND question.content LIKE ? ";
            $params[] = trim("%" . $text . "%");
        }
        else
        {
            $textCondition = "";
        }

        $SQL = "SELECT question.id , content , user.name AS userDisplayName , category.category AS category , time , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? $categoryCondition $textCondition
                ORDER BY ID DESC LIMIT 100";

        return DB::select($SQL , $params);
    }

    public static function searchByTag($tagId)
    {

        $SQL = "SELECT question.id , content , user.name AS userDisplayName , category.category AS category , time , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id IN (SELECT questionId FROM question_tag WHERE tagId = ?)
                ORDER BY ID DESC LIMIT 100";

        return DB::select($SQL , [$tagId]);
    }

    public static function myQuestions($uuid)
    {
        $SQL = "SELECT question.id , content , user.name AS userDisplayName , category.category AS category , time , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE userId IN (SELECT id FROM user WHERE deviceUUID = ?)
                ORDER BY ID DESC LIMIT 100";

        return DB::select($SQL , [$uuid]);
    }

}