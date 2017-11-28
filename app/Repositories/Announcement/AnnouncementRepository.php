<?php

namespace App\Repositories\Announcement;

use App\Enums\AnnouncementActiveState;
use App\Models\Announcement;

/**
 * Created by PhpStorm.
 * User: ali
 * Date: 11/6/17
 * Time: 11:51 AM
 */

class AnnouncementRepository
{

    public static function recentActiveAnnouncements($lang)
    {
        return Announcement::where("active" , AnnouncementActiveState::ACTIVE)->where("lang" , $lang)->orderBy("id" , "DESC")->limit(5)->get();
    }

}