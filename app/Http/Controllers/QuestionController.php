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
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{

    public function index($lang, $type)
    {

        $questions = Question::where("lang", $lang)->where("type", $type)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();
        $announcements = Announcement::where("lang", $lang)->where("type", $type)->orderBy('id', 'DESC')->get();

        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => [$announcements]]);
    }

    public function my($lang)
    {

        $userId = 1;
        $questions = Question::where("lang", $lang)->where("userId", $userId)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);
    }

    public function search($lang)
    {
        $searchtext = Input::get("searchtext");
        $questions = Question::where("lang", $lang)->where("content", 'like', "%" . $searchtext . "%")->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();



        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions],"searchtext"=>$searchtext]);

    }

    public function searchBy($lang)
    {
        $type = Input::get("type");
        $id = Input::get("id");


        $questions = Question::where("lang", $lang)->where("type", $type)->where("categoryId", $id)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);

    }

    public function showSendQuestion($lang)
    {

        return view("$lang.Question.send_question");
    }

    public function send($lang)
    {

        $content = Input::get("message");
        $categoryId = Input::get("category");
        $time = date("Y-m-d h:m:s");

        $userId = 1;
        $type = Input::get("type");
        $status = QuestionStatus::NO_ANSWER;
        $question = new Question();
        $question->content = $content;
        $question->categoryId = $categoryId;
        $question->time = $time;
        $question->userId = $userId;
        $question->type = $type;
        $question->lang = $lang;
        $question->status = $status;

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

        $question = Question::find($id);

        return view("$lang.Question.single_question", ["question" => $question]);
    }

    public function tagQuestion($lang, $tag)
    {

        $questions = DB::table('question')
            ->join('question_tag', 'question.id', '=', 'question_tag.question_id')
            ->join('tag', 'tag.id', '=', 'question_tag.tag_id')
            ->select('question.*', 'tag.tag')->where("tag.tag", $tag)
            ->get();

        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => null]);
    }
}