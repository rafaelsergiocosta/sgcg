<?php

namespace App\Helper;

class DateHelper
{
    public static function formatDate($date, $actualFormat, $newFormat) 
    {
        $dateTimeFormat = date_create_from_format($actualFormat, $date);
        $date = date_format($dateTimeFormat, $newFormat);
        return $date;
    }
}