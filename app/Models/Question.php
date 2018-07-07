<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 8:01 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string content
 * @property \DateTime time
 * @property int userId
 * @property int type
 * @property string lang
 * @property int status
 * @property int privacy
 */
class Question extends Model
{
    protected $table = "question";
    public $timestamps = false;

    public function User()
    {
        return $this->hasOne('App\Models\User','id','userId');
    }

    public function Admin()
    {
        return $this->hasOne('App\Models\Admin','id','adminId');
    }

    public function Category()
    {
        return $this->hasOne('App\Models\Category','id','categoryId');
    }

    public function QuestionTags()
    {
        return $this->hasMany('App\Models\QuestionTag','questionId','id');
    }
}