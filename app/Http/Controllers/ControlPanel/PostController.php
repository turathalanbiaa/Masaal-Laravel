<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\EventLogType;
use App\Models\EventLog;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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
        $posts = is_null(Input::get("q"))?
            Post::where("lang", $lang)
                ->where("type", $type)
                ->orderBy("id", "DESC")
                ->simplePaginate(20) :
            Post::where("title", "like", "%".Input::get("q")."%")
                ->where("lang", $lang)
                ->where("type", $type)
                ->simplePaginate(20);
            ;

        return view("control-panel.$lang.post.index")->with([
            "posts" => $posts
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
        return view("control-panel.$lang.post.create");
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
            "title" => "required",
            "content" => "required",
            "image" => "file|image|min:50|max:500"
        ];
        $rulesMessage = [
            "ar"=>[
                "title.required" => "يرجى ملئ العنوان المنشور.",
                "content.required" => "يرجى ملئ بعض التفاصيل حول المنشور.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 500KB."
            ],
            "fr"=>[
                "title.required" => "S'il vous plaît remplir le titre publié.",
                "content.required" => "S'il vous plaît remplir quelques détails sur la publication.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 500 Ko."
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
            $post = new Post();
            $post->title  = Input::get("title");
            $post->content = Input::get("content");
            $post->lang = $lang;
            $post->type = $type;
            $post->time = date("Y-m-d H:i:s");
            $post->image = is_null(request()->file("image"))?null:Storage::disk('public')->put('', request()->file("image"));
            $post->save();

            //Store event log
            $target = $post->id;
            $type = EventLogType::POST;
            $event = "اضافة منشور من قبل الناشر " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/posts/create")->with([
                "ArCreatePostMessage" => "تم انشاء المنشور بنجاح.",
                "EnCreatePostMessage" => "The publication was successfully created.",
                "FrCreatePostMessage" => "La publication a été créée avec succès."
            ]);
        else
            return redirect("/control-panel/posts/create")->with([
                "ArCreatePostMessage" => "لم يتم انشاء المنشور بنجاح.",
                "EnCreatePostMessage" => "The publication was not created successfully.",
                "FrCreatePostMessage" => "La publication n'a pas été créée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Auth::check();
        $lang = AdminController::getLang();
        return view("control-panel.$lang.post.edit")->with([
            "post" => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Post $post)
    {
        Auth::check();
        $lang = AdminController::getLang();
        $rules = [
            "title" => "required",
            "content" => "required",
            "image" => "file|image|min:50|max:500"
        ];

        $rulesMessage = [
            "ar"=>[
                "title.required" => "يرجى ملئ العنوان المنشور.",
                "content.required" => "يرجى ملئ بعض التفاصيل حول المنشور.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 500KB."
            ],
            "fr"=>[
                "title.required" => "S'il vous plaît remplir le titre publié.",
                "content.required" => "S'il vous plaît remplir quelques détails sur la publication.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 500 Ko."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($post){
            //Remove Old Image
            if (!is_null(Input::get("delete")))
            {
                Storage::disk('public')->delete($post->image);
                $post->image = null;
            }

            //Store new image
            if (!is_null(request()->file("image")))
            {
                Storage::disk('public')->delete($post->image);
                $post->image = Storage::disk('public')->put('', request()->file("image"));
            }

            //Update post
            $post->title  = Input::get("title");
            $post->content = Input::get("content");
            $post->save();

            //Store event log
            $target = $post->id;
            $type = EventLogType::POST;
            $event = "تعديل المنشور من قبل الناشر " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/posts")->with([
                "ArUpdatePostMessage" => "تم تعديل المنشور بنجاح.",
                "EnUpdatePostMessage" => "The publication has been successfully modified.",
                "FrUpdatePostMessage" => "La publication a été modifiée avec succès."
            ]);
        else
            return redirect("/control-panel/posts/$post->id/edit")->with([
                "ArUpdatePostMessage" => "لم يتم تعديل المنشور بنجاح.",
                "EnUpdatePostMessage" => "The publication has not been successfully modified.",
                "FrUpdatePostMessage" => "La publication n'a pas été modifiée avec succès."
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Auth::check();
        //Transaction
        $exception = DB::transaction(function () use ($post){
            //Remove image
            Storage::disk('public')->delete($post->image);

            //Remove post
            $post->delete();

            //Store event log
            $target = $post->id;
            $type = EventLogType::POST;
            $event = "حذف المنشور من قبل الناشر " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/posts")->with([
                "ArDeletePostMessage" => "تم حذف المنشور بنجاح.",
                "EnDeletePostMessage" => "The publication was successfully deleted.",
                "FrDeletePostMessage" => "La publication a été supprimée avec succès."
            ]);
        else
            return redirect("/control-panel/posts")->with([
                "ArDeletePostMessage" => "لم يتم حذف المنشور بنجاح.",
                "EnDeletePostMessage" => "The publication was not deleted successfully.",
                "FrDeletePostMessage" => "La publication n'a pas été supprimée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }
}
