<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 10:57 AM
 */

namespace App\Other\Question;


use App\Enums\QuestionStatus;
use App\Exceptions\NoUserException;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Input;

class QuestionInitializer
{

    public static function initializeNewQuestionObjectFromInput()
    {
        $userId = self::getUserId();

        $question = new Question();
        $question->content = Input::get("content");
        $question->time = new \DateTime();
        $question->userId = $userId;
        $question->type = Input::get("type");
        $question->lang = Input::get("lang");
        $question->status = QuestionStatus::NO_ANSWER;

        return $question;
    }


    private static function getUserId()
    {
        $deviceUUID = Input::get("deviceUUID");
        $inputtedUserId = Input::get("userId" , null);


        $userId = null;
        if ($inputtedUserId)
        {
            $user = User::where("id" , $inputtedUserId)->first();
            if ($user)
                return $inputtedUserId;
        }
        else
        {
            $user = User::where("deviceUUID" , $deviceUUID)->first();
            if ($user)
                return $user->id;
        }

        throw new NoUserException("NO_USER_FOR_QUESTION");
    }

}