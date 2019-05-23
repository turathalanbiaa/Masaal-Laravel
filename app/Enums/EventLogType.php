<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 4/22/2018
 * Time: 9:30 AM
 */

namespace App\Enums;


class EventLogType
{
    const PROFILE = 0;
    const ADMIN = 1;
    const QUESTION = 2;
    const POST = 3;
    const ANNOUNCEMENT = 4;


    public static function getType($key) {
        switch ($key) {
            case self::PROFILE: return "الملف الشخصي"; break;
            case self::ADMIN: return "المدراء"; break;
            case self::QUESTION: return "الأسئلة";  break;
            case self::POST: return "النشورات";  break;
            case self::ANNOUNCEMENT: return "الاعلانات";  break;
        }

        return "";
    }
}