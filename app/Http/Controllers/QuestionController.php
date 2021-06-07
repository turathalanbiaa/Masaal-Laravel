<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:02 PM
 */

namespace App\Http\Controllers;


use App\Enums\QuestionStatus;
use App\Http\Controllers\ControlPanel\AdminController;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Question;
use App\Repositories\Question\QuestionRepository;
use Carbon\Carbon;
use Cassandra\Date;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use mysql_xdevapi\Exception;

class QuestionController extends Controller
{

    public function index(Request $request, $lang, $type)
    {
        //        dump($request->session()->all());
        //    $questions = Question::where("lang", $lang)->where("type", $type)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

//        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND question.type = ? AND status = " . QuestionStatus::APPROVED . "
//                ORDER BY ID DESC";
//

        if ($type == "0") {
            $questions = Question::
            leftJoin('category', 'question.categoryId', '=', 'category.id')
                ->leftJoin('user', 'question.userId', '=', 'user.id')
                ->select('question.id', 'question.type as type', 'question.categoryId as categoryId', 'content', 'user.name as userDisplayName', 'category.category as category', 'time as x', 'answer', 'image', 'status', 'videoLink', 'externalLink')
                ->where("question.lang", $lang)->where("question.privacy", "2")->where("question.status", QuestionStatus::APPROVED)->orderBy('question.id', 'desc')->paginate(20);

        } else {

            $questions = Question::
            leftJoin('category', 'question.categoryId', '=', 'category.id')
                ->leftJoin('user', 'question.userId', '=', 'user.id')
                ->select('question.id', 'question.type as type', 'question.categoryId as categoryId', 'content', 'user.name as userDisplayName', 'category.category as category', 'time as x', 'answer', 'image', 'status', 'videoLink', 'externalLink')
                ->where("question.lang", $lang)->where("question.type", $type)->where("question.privacy", "2")->where("question.status", QuestionStatus::APPROVED)->orderBy('question.id', 'desc')->paginate(20);

        }


        //  $questions = DB::select($SQL, [$lang, $type]);
        $announcements = Announcement::where("lang", $lang)->where("type", $type)->orderBy('id', 'DESC')->paginate(20);

        return view("$lang.question.questions", ["page_title" => "Home", "questions" => $questions, "my_type" => $type, "announcements" => [$announcements]]);
    }

    public function my($lang)
    {


        $userId = session("USER_ID");


        // $questions = Question::where("lang", $lang)->where("userId", $userId)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();
//
//        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND question.userId = ?
//                ORDER BY ID DESC";
//
//        $questions = DB::select($SQL, [$lang, $userId]);
//


        $questions = Question::
        leftJoin('category', 'question.categoryId', '=', 'category.id')
            ->leftJoin('user', 'question.userId', '=', 'user.id')
            ->select('question.id', 'question.type as type', 'question.categoryId as categoryId', 'content', 'user.name as userDisplayName', 'category.category as category', 'time as x', 'answer', 'image', 'status', 'videoLink', 'externalLink')
            ->where("question.lang", $lang)->where("question.userId", $userId)->orderBy('question.id', 'desc')->paginate(20);

        $my_type = 30;
        return view("$lang.question.questions", ["page_title" => "My Questions", "questions" => $questions, "my_type" => $my_type]);
    }

    public function search($lang)
    {
        $searchtext = Input::get("searchtext");
        $searchtext0 = $searchtext;
        $searchtext = "%" . $searchtext . "%";
        //   $questions = Question::where("lang", $lang)->where("content", 'like', "%" . $searchtext . "%")->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();

//        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND content LIKE ? AND status = " . QuestionStatus::APPROVED . "
//                ORDER BY ID DESC";
//
//        $questions = DB::select($SQL, [$lang, $searchtext]);
//
//
//
        $unlink = 0;

        $questions = Question::
        leftJoin('category', 'question.categoryId', '=', 'category.id')
            ->leftJoin('user', 'question.userId', '=', 'user.id')
            ->select('question.id', 'question.type as type', 'question.categoryId as categoryId', 'content', 'user.name as userDisplayName', 'category.category as category', 'time as x', 'answer', 'image', 'status', 'videoLink', 'externalLink')
            ->where("question.lang", $lang)->where("content", "LIKE", $searchtext)->where("question.status", QuestionStatus::APPROVED)->orwhere("answer", "LIKE", $searchtext)->where("question.status", QuestionStatus::APPROVED)->orderBy('question.id', 'desc')->paginate(100);

        $my_type = 31;
        return view("$lang.question.questions", ["page_title" => "My Questions", "questions" => $questions, "searchtext" => $searchtext0, "unlink" => $unlink, "my_type" => $my_type]);

    }

    public function searchBy($lang)
    {
        $type = Input::get("type");
        $id = Input::get("id");


        // $questions = Question::where("lang", $lang)->where("type", $type)->where("categoryId", $id)->where("status", QuestionStatus::APPROVED)->orderBy('id', 'DESC')->get();


//        $SQL = "SELECT question.id ,question.type AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND question.`type` = ? AND categoryId = ? AND status = " . QuestionStatus::APPROVED . "
//                ORDER BY ID DESC";
//
//        $questions = DB::select($SQL, [$lang, $type, $id]);
//
//
        $unlink = 0;

        $questions = Question::
        leftJoin('category', 'question.categoryId', '=', 'category.id')
            ->leftJoin('user', 'question.userId', '=', 'user.id')
            ->select('question.id', 'question.type as type', 'question.categoryId as categoryId', 'content', 'user.name as userDisplayName', 'category.category as category', 'time as x', 'answer', 'image', 'status', 'videoLink', 'externalLink')
            ->where("question.lang", $lang)->where("question.type", $type)->where("categoryId", $id)->where("question.status", QuestionStatus::APPROVED)->orderBy('question.id', 'desc')->paginate(200);

        $my_type = $type;
        return view("$lang.question.questions", ["page_title" => "My Questions", "questions" => $questions, "unlink" => $unlink, "my_type" => $my_type]);

    }

    public function showSendQuestion($lang)
    {

        return view("$lang.question.send_question");
    }

    public function send($lang)
    {

        $content = Input::get("message");
        $privacy = Input::get("privacy");
        $type = Input::get("type");

        $time = date("Y-m-d h:m:s");
        if (session("USER_ID") != null) {
            $userId = session("USER_ID");
        } else {
            if (app()->getLocale() == "en") 
                $userId = 2;
            elseif (app()->getLocale() == "fr")
                $userId = 3;
            else
                $userId = 1;
        }

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
        $third_category = Category::where("lang", $lang)->where("type", 3)->get();
        $fourth_categorys = Category::where("lang", $lang)->where("type", 4)->get();

        return view("$lang.question.categories", ["first_categorys" => $first_categorys, "second_categorys" => $second_categorys, "third_categorys" => $third_category, "fourth_categorys" => $fourth_categorys]);
    }

    public function showQuestion($lang, $id)
    {
        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";


        $questions = DB::select($SQL, [$id]);
        $question = array_values($questions)[0];


        $SQL = "SELECT * , comment.id as  comment_id   , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";

        $comments = DB::select($SQL, [$id]);

        return view("$lang.question.single_question", ["question" => $question, "comments" => $comments]);
    }

    public function delete_comment($lang, $id, $comment_id)
    {


        $SESSION = Cookie::get("SESSION");

        if ($SESSION) {

            $user = \App\Models\User::where('session', $SESSION)->first();
            try {
                $comment = Comment::find($comment_id);

                if ($user->id == $comment->user_id) {
                    $comment->delete();

                }
            } catch (\Exception $e) {

            }


            $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";


            $questions = DB::select($SQL, [$id]);
            $question = array_values($questions)[0];


            $SQL = "SELECT * , comment.id as  comment_id   , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";

            $comments = DB::select($SQL, [$id]);

            return view("$lang.question.single_question", ["question" => $question, "comments" => $comments]);


        } else {
            return redirect("$lang/login");
        }


    }
    public function DeleteComments( $id, $comment_id)
    {


        $SESSION = Cookie::get("SESSION");

        if ($SESSION) {

            $user = \App\Models\User::where('session', $SESSION)->first();
            try {
                $comment = Comment::find($comment_id);

                if ($user->id == $comment->user_id) {
                    $comment->delete();

                }
            } catch (\Exception $e) {

            }


            $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";


            $questions = DB::select($SQL, [$id]);
            $question = array_values($questions)[0];


            $SQL = "SELECT * , comment.id as  comment_id   , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";

            $comments = DB::select($SQL, [$id]);

            return view("$lang.question.single_question", ["question" => $question, "comments" => $comments]);


        } else {
            return redirect("$lang/login");
        }


    }

    public function insert_comment(Request $request, $lang, $id)
    {


        $content = $request->input("content", "");


        $SESSION = Cookie::get("SESSION");

        if ($SESSION) {

            $user = \App\Models\User::where('session', $SESSION)->first();

            $comment = new Comment();
            $comment->user_id = $user->id;
            $comment->content = $content;
            $comment->question_id = $id;
            $comment->type = 1;
            $comment->date_time = Carbon::now();

            $comment->save();


            $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";


            $questions = DB::select($SQL, [$id]);
            $question = array_values($questions)[0];


            $SQL = "SELECT * , comment.id as  comment_id    , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";

            $comments = DB::select($SQL, [$id]);

            return view("$lang.question.single_question", ["question" => $question, "comments" => $comments]);


        } else {
            return redirect("$lang/login");
        }


    }

    public function insert_reply(Request $request, $lang, $id, $comment_replyed_id)
    {


        $content = $request->input("content", "");

        $AdminControllerId = AdminController::getId();

        if ($AdminControllerId) {


            $comment = new Comment();
            $comment->user_id = $AdminControllerId;
            $comment->admin_id = $AdminControllerId;
            $comment->content = $content;
            $comment->question_id = $id;
            $comment->type = 2;
            $comment->date_time = Carbon::now();

            $comment->save();

            $old_comment = Comment::find($comment_replyed_id);
            $old_comment->comment_replyed_id = $comment->id;
            $old_comment->reply_text =  $comment->content ;
            $old_comment->save();
//            $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.id = ?";
//
//
//            $questions = DB::select($SQL, [$id]);
//            $question = array_values($questions)[0];
//
//
//
//            $SQL = "SELECT * , comment.id as  comment_id    , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";
//
//            $comments = DB::select($SQL, [$id]);

            return redirect("/control-panel/respondent/my-comments");


        } else {
            return redirect("$lang/login");
        }


    }

    public function tagQuestion($lang, $tag)
    {

//        $SQL = "SELECT question.id ,question.type AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink
//                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
//                WHERE question.lang = ? AND question.`type` = ? AND categoryId = ?
//                ORDER BY ID DESC";
//
//
//        $questions = DB::table('question')
//            ->join('question_tag', 'question.id', '=', 'question_tag.question_id')
//            ->join('tag', 'tag.id', '=', 'question_tag.tag_id')
//            ->select('question.*', 'tag.tag')->where("tag.tag", $tag)
//            ->get();


        $questions = QuestionRepository::searchByTag($tag);
        $unlink = 0;
        $my_type = 32;

        return view("$lang.question.questions", ["page_title" => "Home", "questions" => $questions, "announcements" => null, "unlink" => $unlink, "my_type" => $my_type]);
    }
}