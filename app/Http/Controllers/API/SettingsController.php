<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/26/17
 * Time: 9:13 AM
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Input;

class SettingsController extends Controller
{


    public function changeName()
    {
        sleep(2);

        $name = Input::get("name");
        $uuid = Input::get("deviceUUID");
        $deviceType = Input::get("deviceType");

        $user = User::where("deviceUUID" , $uuid)->first();
        if ($user)
        {
            $user->name = $name;
            $success = $user->save();
            return ["success" => $success];
        }
        else
        {
            $user = new User();
            $user->name = $name;
            $user->deviceUUID = $uuid;
            $user->deviceType = $deviceType;
            $user->registrationDate = new \DateTime();
        }

        return ["success" => false];
    }

}