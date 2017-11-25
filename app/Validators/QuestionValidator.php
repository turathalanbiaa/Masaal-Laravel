<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 7:57 AM
 */

namespace App\Validators;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class QuestionValidator
{
    private $data;

    /**
     * QuestionValidator constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function pass()
    {
        $rules = [
            'content' => "required|string|min:10" ,
            'type' => "required|in:1,2" ,
            'privacy' => "required|in:1,2" ,
            'lang' => "required|in:ar,en,fr" ,
        ];

        $validator = Validator::make($this->data , $rules);
        $valid = !$validator->fails();

        if ($valid)
        {
            if ($this->validateUser())
                return true;
        }

        return false;
    }

    private function validateUser()
    {
        $inputtedUserId = $this->data["userId"] ?? null;
        $deviceUUID = $this->data["deviceUUID"] ?? null;
        if ($inputtedUserId)
        {
            $user = User::where("id" , $inputtedUserId)->first();
            if ($user)
                return true;
        }
        else if ($deviceUUID)
        {
            $user = User::where("deviceUUID" , $deviceUUID)->first();
            if ($user)
                return true;
        }

        return false;
    }

    public static function validate($data)
    {
        $validator = new QuestionValidator($data);
        return $validator->pass();
    }

}