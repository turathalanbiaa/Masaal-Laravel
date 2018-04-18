<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
    protected $table = "question_tag";
    public $timestamps = false;

    public function Tag()
    {
        return $this->hasOne('App\Models\Tag','id','tagId');
    }
}
