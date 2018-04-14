<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $table = "event_log";
    protected $primaryKey = "id";
    public $timestamps = false;
}
