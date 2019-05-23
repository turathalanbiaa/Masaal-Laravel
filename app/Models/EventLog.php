<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $table = "event_log";
    public $timestamps = false;

    public static function create($target, $type, $event)
    {
        $eventLog = new EventLog();
        $eventLog->admin_id = session()->get("MASAEL_CP_ADMIN_ID");
        $eventLog->event = $event;
        $eventLog->type = $type;
        $eventLog->target = $target;
        $eventLog->time = date("Y-m-d h:i:s", time());
        $eventLog->save();
    }
}
