<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = "subject";
    public $timestamps = false;


    public function Content()
    {
        return $this->hasMany('App\Content','questionId','id');
    }


}
