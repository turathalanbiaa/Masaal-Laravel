<?php

namespace App\Models;

use App\Enums\QuestionStatus;
use App\Http\Controllers\ControlPanel\MainController;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admin";
    public $timestamps = false;

    /**
     * Get permission for the specific admin
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne("App\Models\Permission");
    }

    /**
     * Get unanswered questions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unansweredQuestions()
    {
        return $this->hasMany("App\Models\Question", "adminId", "id")
            ->where("status", QuestionStatus::NO_ANSWER);
    }
}
