<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:02 PM
 */

namespace App\Http\Controllers;


use App\Enums\QuestionStatus;
use App\Models\Announcement;
use App\Models\Question;

class QuestionController extends Controller
{

    public function index($lang ,$type)
    {

        $questions  = Question::where("lang",$lang)->where("type",$type)->where("status",QuestionStatus::APPROVED)->get();
        $announcements = Announcement::where("lang",$lang)->where("type",$type)->get();

        return view("$lang.Question.questions" , ["page_title" => "Home" , "questions" => [$questions] , "announcements" => [$announcements]]);
    }

    public function my($lang)
    {
        $type = "1";
        $userId = 1;
        $questions  = Question::where("lang",$lang)->where("type",$type)->where("userId",$userId)->where("status",QuestionStatus::APPROVED)->get();

        return view("$lang.Question.questions" , ["page_title" => "My Questions" , "questions" => [$questions]]);
    }

    public function search($lang)
    {
        return view("$lang.Question.questions" , ["page_title" => "My Questions" , "questions" => []]);
    }

    public function searchBy($lang)
    {
        return view("$lang.Question.questions" , ["page_title" => "My Questions" , "questions" => []]);
    }

    public function showSendQuestion($lang)
    {
        return view("$lang.Question.send_question");
    }

    public function q_a($lang)
    {
        return view("$lang.Question.q_a" , ["items" => []]);
    }

    public function showCategories($lang)
    {
        return view("$lang.Question.categories");
    }

    public function showQuestion($lang , $id)
    {

        $question  = Question::find($id);

        return view("$lang.Question.single_question" ,["question"=>$question]);
    }
}