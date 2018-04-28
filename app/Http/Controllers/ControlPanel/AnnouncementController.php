<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\TargetName;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AnnouncementController extends Controller
{
    public function announcements(){
        $currentAdmin = Input::get("currentAdmin");
        if (!is_null(Input::get("query")))
        {
            $query = Input::get("query");
            $announcements = Announcement::where("content", "like", "%" . $query . "%")
                ->where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("content")
                ->simplePaginate(20);
        } else {
            $announcements = Announcement::where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("id")
                ->simplePaginate(20);
        }

        return view("cPanel.$currentAdmin->lang.announcement.announcements")->with([
            "announcements" => $announcements,
            "lang" => $currentAdmin->lang
        ]);
    }

    public function delete(Request $request){
        $id = Input::get("id");
        $announcement = Announcement::find($id);

        if (!$announcement)
            return ["notFound"=>true];

        $success = $announcement->delete();

        if (!$success)
            return ["success"=>false];

        EventLogController::add($request, "DELETE ANNOUNCEMENT", TargetName::ANNOUNCEMENT, $id);
        return ["success"=>true];
    }

    public function create(){
        $currentAdmin = Input::get("currentAdmin");
        return view("cPanel.$currentAdmin->lang.announcement.create")->with(["lang" => $currentAdmin->lang]);
    }

    public function createValidation(Request $request){
        $currentAdmin = Input::get("currentAdmin");

        $rules = [
            "content" => "required"
        ];

        $rulesMessage = [
            "ar"=>[
                "content.required" => "الاعلان لا يحتوي على اي معلومات."
            ],
            "fr"=>[
                "content.required" => "L'annonce ne contient aucune information."
            ]
        ];

        if ($currentAdmin->lang == "en")
            $this->validate($request, $rules, []);

        if ($currentAdmin->lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($currentAdmin->lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $announcement = new Announcement();
        $announcement->content = Input::get("content");
        $announcement->lang = $currentAdmin->lang;
        $announcement->type = $currentAdmin->type;
        $announcement->time = date("Y-m-d H:i:s");
        $announcement->active = Input::get("active") ?? 0;

        $success = $announcement->save();

        if (!$success)
            return redirect("/control-panel/$currentAdmin->lang/announcement/create")->with([
                "ArInfoMessage" => "لم يتم حفظ الاعلان.",
                "EnInfoMessage" => "Ad not saved.",
                "FrInfoMessage" => "Annonce non enregistrée"
            ]);

        EventLogController::add($request, "CREATE ANNOUNCEMENT", TargetName::ANNOUNCEMENT, $announcement->id);

        return redirect("/control-panel/$currentAdmin->lang/announcement/create")->with([
            "ArInfoMessage" => "تم حفظ الاعلان.",
            "EnInfoMessage" => "Ad saved.",
            "FrInfoMessage" => "Annonce enregistrée"
        ]);
    }

    public function active(Request $request){
        $id = Input::get("id");
        $announcement = Announcement::find($id);

        if (!$announcement)
            return ["notFound"=>true];

        $announcement->active = Input::get("status");
        $success = $announcement->save();

        if (!$success)
            return ["success"=>false];

        EventLogController::add($request, "ACTIVE ANNOUNCEMENT", TargetName::ANNOUNCEMENT, $id);
        return ["success"=>true];
    }
}
