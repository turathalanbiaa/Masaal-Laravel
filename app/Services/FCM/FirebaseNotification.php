<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/29/17
 * Time: 10:49 AM
 */

namespace App\Services\FCM;


class FirebaseNotification
{


    public static function toDevice($token , $message , $type , $extra)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'to' => $token,
            'notification' => [
                "body" => $message ,
                "type" => $type ,
                "extra" => $extra
            ] ,
            "data" => [
                "message" => $message ,
                "type" => $type ,
                "extra" => $extra
            ]
        );
        $fields = json_encode ( $fields );

        $headers = array (
            'Authorization: key=' . "AIzaSyCHJ19GrKUfja42BaVrPexq2EIGXbUr-9g",
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        return $result;

    }

}