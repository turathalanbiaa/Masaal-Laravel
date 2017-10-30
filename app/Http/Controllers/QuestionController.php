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

    public function index()
    {
        return view("en.question.questions" , ["page_title" => "Home" , "questions" => [] , "announcement" => true]);
    }

    public function my()
    {
        return view("en.question.questions" , ["page_title" => "My Questions" , "questions" => []]);
    }

    public function search()
    {
        return view("en.question.questions" , ["page_title" => "My Questions" , "questions" => []]);
    }

    public function searchBy()
    {
        return view("en.question.questions" , ["page_title" => "My Questions" , "questions" => []]);
    }

    public function showSendQuestion()
    {
        return view("en.question.send_question");
    }

    public function q_a()
    {
        return view("en.question.q_a" , ["items" => []]);
    }

    public function showCategories()
    {
        return view("en.question.categories");
    }

}