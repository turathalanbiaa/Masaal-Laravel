<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/29/17
 * Time: 11:02 AM
 */

namespace App\Http\Controllers\API;


use App\Enums\FirebaseNotificationType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FCM\FirebaseNotification;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller
{

    public function sendToDevice()
    {
        $token = Input::get("token");
        $result = FirebaseNotification::toDevice($token , "You have " . time() , FirebaseNotificationType::ANSWER , "1");
        return ["result" => $result];
    }

    public function registerToken()
    {
        $token = Input::get("token");
        $deviceUUID = Input::get("deviceUUID");

        $user = User::where("deviceUUID" , $deviceUUID)->first();
        if($user)
        {
            $user->firebaseToken = $token;
            $success = $user->save();
            return ["success" => $success];
        }

        return ["success" => false];
    }

}