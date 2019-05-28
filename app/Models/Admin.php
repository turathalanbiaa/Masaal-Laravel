<?php

namespace App\Models;

use App\Enums\QuestionStatus;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admin";
    public $timestamps = false;

    public function permission()
    {
        return $this->hasOne("App\Models\Permission");
    }

    public function unansweredQuestions()
    {
        return $this->hasMany("App\Models\Question", "adminId", "id")
            ->where("status", QuestionStatus::NO_ANSWER)
            ->get();
    }
}
