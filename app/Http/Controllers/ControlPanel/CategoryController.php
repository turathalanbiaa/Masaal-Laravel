<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\EventLogType;
use App\Models\Category;
use App\Models\EventLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
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
        $categories = is_null(Input::get("q"))?
            Category::where("lang", $lang)
                ->where("type", $type)
                ->orderBy("id", "DESC")
                ->simplePaginate(20) :
            Category::where("category", "like", "%".Input::get("q")."%")
                ->where("lang", $lang)
                ->where("type", $type)
                ->simplePaginate(20);
        ;

        return view("control-panel.$lang.category.index")->with([
            "categories" => $categories
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
        return view("control-panel.$lang.category.create");
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
            "category" => "required"
        ];
        $rulesMessage = [
            "ar"=>[
                "category.required" => "يرجى ملئ الصنف."
            ],
            "fr"=>[
                "title.required" => "S'il vous plaît remplir l'élément.",
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
            $category = new Category();
            $category->category  = Input::get("category");
            $category->lang = $lang;
            $category->type = $type;
            $category->save();

            //Store event log
            $target = $category->id;
            $type = EventLogType::CATEGORY;
            $event = "اضافة صنف من قبل المدير " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/categories/create")->with([
                "ArCreateCategoryMessage" => "تمت اضافة الصنف بنجاح.",
                "EnCreateCategoryMessage" => "Category successfully added.",
                "FrCreateCategoryMessage" => "Catégorie ajoutée avec succès."
            ]);
        else
            return redirect("/control-panel/categories/create")->with([
                "ArCreateCategoryMessage" => "لم تمم اضافة الصنف بنجاح.",
                "EnCreateCategoryMessage" => "The category has not been successfully added.",
                "FrCreateCategoryMessage" => "Catégorie n'a pas été ajouté avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        Auth::check();
        $lang = AdminController::getLang();
        return view("control-panel.$lang.category.edit")->with([
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        Auth::check();
        $lang = AdminController::getLang();
        $rules = [
            "category" => "required"
        ];
        $rulesMessage = [
            "ar"=>[
                "category.required" => "يرجى ملئ الصنف."
            ],
            "fr"=>[
                "title.required" => "S'il vous plaît remplir l'élément.",
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($category){
            //Update category
            $category->category  = Input::get("category");
            $category->save();

            //Store event log
            $target = $category->id;
            $type = EventLogType::CATEGORY;
            $event = "تعديل الصنف من قبل المدير " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/categories")->with([
                "ArUpdateCategoryMessage" => "تم تعديل الصنف بنجاح.",
                "EnUpdateCategoryMessage" => "Category has been successfully modified.",
                "FrUpdateCategoryMessage" => "Catégorie a été modifié avec succès."
            ]);
        else
            return redirect("/control-panel/categories/$category->id/edit")->with([
                "ArUpdateCategoryMessage" => "لم يتم تعديل الصنف بنجاح.",
                "EnUpdateCategoryMessage" => "The category has not been successfully modified.",
                "FrUpdateCategoryMessage" => "Catégorie n'a pas été modifié avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Auth::check();
        //Transaction
        $exception = DB::transaction(function () use ($category){
            //Remove post
            $category->delete();

            //Store event log
            $target = $category->id;
            $type = EventLogType::CATEGORY;
            $event = "حذف الصنف من قبل المدير " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/categories")->with([
                "ArDeleteCategoryMessage" => "تم حذف الصنف بنجاح.",
                "EnDeleteCategoryMessage" => "Category successfully deleted.",
                "FrDeleteCategoryMessage" => "Catégorie supprimé avec succès."
            ]);
        else
            return redirect("/control-panel/categories")->with([
                "ArDeleteCategoryMessage" => "لم يتم حذف الصنف بنجاح.",
                "EnDeleteCategoryMessage" => "the category not successfully deleted.",
                "FrDeleteCategoryMessage" => "Catégorie n'a pas été supprimé avec succès.",
                "TypeMessage" => "Error"
            ]);
    }
}
