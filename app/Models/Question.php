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



}