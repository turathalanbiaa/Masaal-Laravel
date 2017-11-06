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
        $limit = 3;
        $offset = Input::get("offset" , 0);
        $announcements = AnnouncementRepository::recentActiveAnnouncements();
        $questions = QuestionRepository::getRecentQuestions($limit , $offset);
        return ["questions" => $questions , "announcements" => $announcements];
    }


}