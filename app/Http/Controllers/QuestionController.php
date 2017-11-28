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
use App\Models\Category;
use App\Models\Question;
use App\Repositories\Question\QuestionRepository;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{

    public function index(Request $request , $lang, $type)
    {
        dump($request->session()->all());
        //    $questions = Question::where("lang", $lang)->where("type", $type)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();
        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? AND question.type = ? AND status = " . QuestionStatus::APPROVED . " 
                ORDER BY ID DESC";

        $questions = DB::select($SQL, [$lang, $type]);
        $announcements = Announcement::where("lang", $lang)->where("type", $type)->orderBy('id', 'DESC')->get();

        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => [$announcements]]);
    }

    public function my($lang)
    {

        $userId = 1;
        // $questions = Question::where("lang", $lang)->where("userId", $userId)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? AND question.userId = ? AND status = " . QuestionStatus::APPROVED . "
                ORDER BY ID DESC";

        $questions = DB::select($SQL, [$lang, $userId]);
        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);
    }

    public function search($lang)
    {
        $searchtext = Input::get("searchtext");
        $searchtext0 = $searchtext;
        $searchtext = "%" . $searchtext . "%";
        //   $questions = Question::where("lang", $lang)->where("content", 'like', "%" . $searchtext . "%")->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? AND content LIKE ? AND status = " . QuestionStatus::APPROVED . "
                ORDER BY ID DESC";

        $questions = DB::select($SQL, [$lang, $searchtext]);

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions], "searchtext" => $searchtext0]);

    }

    public function searchBy($lang)
    {
        $type = Input::get("type");
        $id = Input::get("id");


        // $questions = Question::where("lang", $lang)->where("type", $type)->where("categoryId", $id)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();


        $SQL = "SELECT question.id ,question.type AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.lang = ? AND question.`type` = ? AND categoryId = ? AND status = " . QuestionStatus::APPROVED . "
                ORDER BY ID DESC";

        $questions = DB::select($SQL, [$lang, $type, $id]);

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);

    }

    public function showSendQuestion($lang)
    {

        return view("$lang.Question.send_question");
    }

    public function send($lang)
    {

        $content = Input::get("message");
        $privacy = Input::get("privacy");
        $type = Input::get("type");

        $time = date("Y-m-d h:m:s");

        $userId = 1;
        $status = QuestionStatus::NO_ANSWER;
        $question = new Question();
        $question->content = $content;

        $question->time = $time;
        $question->userId = $userId;
        $question->type = $type;
        $question->lang = $lang;
        $question->status = $status;
        $question->privacy = $privacy;
        $question->save();
        return $this->my($lang);
    }

    public function showCategories($lang)
    {


        $first_categorys = Category::where("lang", $lang)->where("type", 1)->get();
        $second_categorys = Category::where("lang", $lang)->where("type", 2)->get();

        return view("$lang.Question.categories", ["first_categorys" => $first_categorys, "second_categorys" => $second_categorys]);
    }

    public function showQuestion($lang, $id)
    {
        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";

        $questions = DB::select($SQL, [$id]);
        $question = array_values($questions)[0];
        return view("$lang.Question.single_question", ["question" => $question]);
    }

    public function tagQuestion($lang, $tag)
    {
//
//        $SQL = "SELECT question.id ,question.type AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND question.`type` = ? AND categoryId = ?
//                ORDER BY ID DESC";


//        $questions = DB::table('question')
//            ->join('question_tag', 'question.id', '=', 'question_tag.question_id')
//            ->join('tag', 'tag.id', '=', 'question_tag.tag_id')
//            ->select('question.*', 'tag.tag')->where("tag.tag", $tag)
//            ->get();
//

        $questions = QuestionRepository::searchByTag($tag);


        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => null]);
    }
}