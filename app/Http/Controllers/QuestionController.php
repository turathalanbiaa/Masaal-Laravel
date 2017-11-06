<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:02 PM
 */

namespace App\Http\Controllers;


class QuestionController extends Controller
{

    public function index($lang)
    {
        return view("$lang.Question.questions" , ["page_title" => "Home" , "questions" => [] , "announcement" => true]);
    }

    public function my($lang)
    {
        return view("$lang.Question.questions" , ["page_title" => "My Questions" , "questions" => []]);
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

}