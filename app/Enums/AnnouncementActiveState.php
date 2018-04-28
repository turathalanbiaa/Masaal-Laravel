<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 11:53 AM
 */

namespace App\Enums;


class AnnouncementActiveState
{
    const ACTIVE = 1;
    const DISABLED = 0;

    public static function getAnnouncementActiveState($key){
        switch ($key)
        {
            case AnnouncementActiveState::ACTIVE : return "مفعل";
            case AnnouncementActiveState::DISABLED : return "غير مفعل";
            default: return "";
        }
    }
}