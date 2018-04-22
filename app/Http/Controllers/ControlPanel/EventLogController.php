<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\EventLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class EventLogController extends Controller
{
    public static function add(Request $request, $event, $targetName, $targetId)
    {
        $currentAdmin = Input::get("currentAdmin");

        $row = new EventLog();
        $row->adminUsername = $currentAdmin->username;
        $row->lang = $currentAdmin->lang;
        $row->event = $event;
        $row->targetName = $targetName;
        $row->targetId = $targetId;
        $row->save();

        return "";
    }
}
