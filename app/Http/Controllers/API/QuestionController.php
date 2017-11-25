<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Other\Question\QuestionInitializer;
use App\Repositories\Announcement\AnnouncementRepository;
use App\Repositories\Question\QuestionRepository;
use App\Validators\QuestionValidator;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 11:11 AM
 */

class QuestionController extends Controller
{

    public function createNewQuestion()
    {
        sleep(2);
        if (QuestionValidator::validate(Input::all()))
        {
            $question = QuestionInitializer::initializeNewQuestionObjectFromInput();
            $success = $question->save();
            return ["success" => $success , "valid" => true , "id" => $question->id];
        }
        else
        {
            return ["success" => false , "valid" => false];
        }
    }

    public function recentQuestionsWithAnnouncements()
    {
        sleep(2);
        $limit = 10;
        $offset = Input::get("offset" , 0);
        $lang = Input::get("lang" , "ar");
        $type = Input::get("type" , 1);
        $announcements = AnnouncementRepository::recentActiveAnnouncements();
        $questions = QuestionRepository::getRecentQuestions($lang , $type , $limit , $offset);
        return ["questions" => $questions , "announcements" => $announcements];
    }

    public function search()
    {
        sleep(2);
        $lang = Input::get("lang" , "ar");
        $text = Input::get("text" , "");
        $category = Input::get("category" , "");

        $questions = QuestionRepository::search($lang , $text , $category);
        return ["questions" => $questions];
    }

    public function searchByTag()
    {
        sleep(2);
        $tagId = Input::get("tagId" , null);

        if (empty($tagId) || !is_numeric($tagId))
        {
            return ["questions" => []];
        }

        $questions = QuestionRepository::searchByTag($tagId);
        return ["questions" => $questions];
    }

    public function myQuestions()
    {
        sleep(2);
        $uuid = Input::get("deviceUUID" , null);
        $questions = QuestionRepository::myQuestions($uuid);
        return ["questions" => $questions];
    }


}