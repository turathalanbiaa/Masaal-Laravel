<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\EventLogType;
use App\Models\Announcement;
use App\Models\EventLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::check();
        $lang = AdminController::getLang();
        $type = AdminController::getType();
        $announcements = is_null(Input::get("q"))?
            Announcement::where("lang", $lang)
                ->where("type", $type)
                ->orderBy("id", "DESC")
                ->simplePaginate(20) :
            Announcement::where("content", "like", "%".Input::get("q")."%")
                ->where("lang", $lang)
                ->where("type", $type)
                ->simplePaginate(20);
        ;

        return view("control-panel.$lang.announcement.index")->with([
            "announcements" => $announcements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::check();
        $lang = AdminController::getLang();
        return view("control-panel.$lang.announcement.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Auth::check();
        $lang = AdminController::getLang();
        $type = AdminController::getType();
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

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($lang, $type){
            //Store announcement
            $announcement = new Announcement();
            $announcement->content = Input::get("content");
            $announcement->lang = $lang;
            $announcement->type = $type;
            $announcement->time = date("Y-m-d H:i:s");
            $announcement->active = Input::get("active") ?? 0;
            $announcement->save();

            //Store event log
            $target = $announcement->id;
            $type = EventLogType::ANNOUNCEMENT;
            $event = "اضافة اعلان من قبل المعلن " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/announcements/create")->with([
                "ArCreateAnnouncementMessage" => "تم انشاء الاعلان بنجاح.",
                "EnCreateAnnouncementMessage" => "Ad successfully created.",
                "FrCreateAnnouncementMessage" => "Annonce créée avec succès."
            ]);
        else
            return redirect("/control-panel/announcements/create")->with([
                "ArCreateAnnouncementMessage" => "لم يتم انشاء الاعلان بنجاح.",
                "EnCreateAnnouncementMessage" => "The ad was not created successfully.",
                "FrCreateAnnouncementMessage" => "L'annonce n'a pas été créée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        Auth::check();
        $lang = AdminController::getLang();
        return view("control-panel.$lang.announcement.edit")->with([
            "announcement" => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Announcement $announcement
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Announcement $announcement)
    {
        Auth::check();

        //Change active state
        if (Input::get("active"))
        {
            //Transaction
            $exception = DB::transaction(function () use ($announcement){
                //Update announcement
                $announcement->active = Input::get("active");
                $announcement->save();

                //Store event log
                $target = $announcement->id;
                $type = EventLogType::ANNOUNCEMENT;
                $event = "تم تفعيل الاعلان من قبل المعلن " . AdminController::getName();
                EventLog::create($target, $type, $event);
            });

            if (is_null($exception))
                return redirect("/control-panel/announcements")->with([
                    "ArActiveAnnouncementMessage" => "تم تغيير حالة الاعلان بنجاح.",
                    "EnActiveAnnouncementMessage" => "Ad status changed successfully.",
                    "FrActiveAnnouncementMessage" => "Le statut de l'annonce a bien été modifié."
                ]);
            else
                return redirect("/control-panel/announcements")->with([
                    "ArActiveAnnouncementMessage" => "لم يتم تغيير حالة الاعلان بنجاح.",
                    "EnActiveAnnouncementMessage" => "Ad status has not changed successfully.",
                    "FrActiveAnnouncementMessage" => "Le statut de annonce n'a pas été modifié avec succès.",
                    "TypeMessage" => "Error"
                ]);
        }

        //Update announcement
        $lang = AdminController::getLang();
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

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($announcement){
            //Update announcement
            $announcement->content = Input::get("content");
            $announcement->save();

            //Store event log
            $target = $announcement->id;
            $type = EventLogType::ANNOUNCEMENT;
            $event = "تعديل الاعلان من قبل المعلن " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/announcements")->with([
                "ArUpdateAnnouncementMessage" => "تم تعديل الاعلان بنجاح.",
                "EnUpdateAnnouncementMessage" => "Ad modified successfully.",
                "FrUpdateAnnouncementMessage" => "Annonce modifiée avec succès."
            ]);
        else
            return redirect("/control-panel/announcements/$announcement->id/edit")->with([
                "ArUpdateAnnouncementMessage" => "لم يتم تعديل الاعلان بنجاح.",
                "EnUpdateAnnouncementMessage" => "Ad has not been successfully edited.",
                "FrUpdateAnnouncementMessage" => "Annonce n'a pas été modifiée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        Auth::check();
        //Transaction
        $exception = DB::transaction(function () use ($announcement){
            //Remove announcement
            $announcement->delete();

            //Store event log
            $target = $announcement->id;
            $type = EventLogType::ANNOUNCEMENT;
            $event = "حذف الاعلان من قبل المعلن " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/announcements")->with([
                "ArDeleteAnnouncementMessage" => "تم حذف الاعلان بنجاح.",
                "EnDeleteAnnouncementMessage" => "Ad successfully deleted.",
                "FrDeleteAnnouncementMessage" => "Annonce supprimée avec succès."
            ]);
        else
            return redirect("/control-panel/announcements")->with([
                "ArDeleteAnnouncementMessage" => "لم يتم حذف الاعلان بنجاح.",
                "EnDeleteAnnouncementMessage" => "Ad not successfully deleted.",
                "FrDeleteAnnouncementMessage" => "L'annonce n'a pas été supprimée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }
}
