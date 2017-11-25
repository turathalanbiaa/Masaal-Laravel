<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/25/2017
 * Time: 2:18 PM
 */

namespace App\Enums;


class QuestionType
{
    const FEQHI = 1;
    const AKAEDI = 2;

    public static function getQuestionTypeName($key)
    {
        switch ($key)
        {
            case QuestionType::FEQHI : return "فقهي";
            case QuestionType::AKAEDI : return "عقائدي";
            default: return "";
        }
    }
}