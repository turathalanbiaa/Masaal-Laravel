<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\TargetName;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function posts(){
        $currentAdmin = Input::get("currentAdmin");
        if (!is_null(Input::get("query")))
        {
            $query = Input::get("query");
            $posts = Post::where("title", "like", "%" . $query . "%")
                ->where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("title")
                ->simplePaginate(20);
        } else {
            $posts = Post::where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("id")
                ->simplePaginate(20);
        }

        return view("cPanel.$currentAdmin->lang.post.posts")->with([
            "posts" => $posts,
            "lang" => $currentAdmin->lang
        ]);
    }

    public function delete(Request $request){
        $id = Input::get("id");
        $post = Post::find($id);

        if (!$post)
            return ["notFound"=>true];

        $success = $post->delete();

        if (!$success)
            return ["success"=>false];

        EventLogController::add($request, "DELETE POST", TargetName::POST, $id);
        return ["success"=>true];
    }

    public function create(){
        $currentAdmin = Input::get("currentAdmin");
        return view("cPanel.$currentAdmin->lang.post.create")->with(["lang" => $currentAdmin->lang]);
    }

    public function createValidation(Request $request){
        $currentAdmin = Input::get("currentAdmin");

        $rules = [
            "title" => "required",
            "content" => "required",
            "image" => "file|image|min:50|max:200"
        ];

        $rulesMessage = [
            "ar"=>[
                "title.required" => "يرجى ملئ العنوان المنشور.",
                "content.required" => "يرجى ملئ بعض التفاصيل حول المنشور.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 200KB."
            ],
            "fr"=>[
                "title.required" => "S'il vous plaît remplir le titre publié.",
                "content.required" => "S'il vous plaît remplir quelques détails sur la publication.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 200 Ko."
            ]
        ];

        if ($currentAdmin->lang == "en")
            $this->validate($request, $rules, []);

        if ($currentAdmin->lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($currentAdmin->lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $post = new Post();
        $post->title  = Input::get("title");
        $post->content = Input::get("content");
        $post->lang = $currentAdmin->lang;
        $post->type = $currentAdmin->type;
        $post->time = date("Y-m-d H:i:s");
        $post->image = null;
        if (!is_null(request()->file("image")))
        {
            $path = Storage::putFile("public", request()->file("image"));
            $imagePath = explode('/',$path);
            $post->image = $imagePath[1];
        }

        $success = $post->save();

        if (!$success)
            return redirect("/control-panel/$currentAdmin->lang/post/create")->with([
                "ArInfoMessage" => "لم يتم حفظ المنشور.",
                "EnInfoMessage" => "The publication was not saved.",
                "FrInfoMessage" => "La publication n'a pas été enregistrée."
            ]);

        EventLogController::add($request, "CREATE POST", TargetName::POST, $post->id);

        return redirect("/control-panel/$currentAdmin->lang/post/create")->with([
            "ArInfoMessage" => "تم حفظ المنشور.",
            "EnInfoMessage" => "Your publication has been saved.",
            "FrInfoMessage" => "Votre publication a été enregistrée."
        ]);
    }
}
