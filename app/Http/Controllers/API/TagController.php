<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/23/17
 * Time: 9:27 AM
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Repositories\Tag\TagRepository;
use Illuminate\Support\Facades\Input;

class TagController extends Controller
{
    public function all()
    {
        $lang = Input::get("lang" , "en");
        return TagRepository::all($lang);
    }
}