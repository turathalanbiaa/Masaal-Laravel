<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\EventLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class EventLogController extends Controller
{
    public static function add(Request $request, $event , $target_Id)
    {
        $currentAdmin = Input::get("currentAdmin");

        $row = new EventLog();
        $row->adminUsername = $currentAdmin->username;
        $row->event = $event;
        $row->target_Id = $target_Id;
        $row->save();

        return "";
    }
}
