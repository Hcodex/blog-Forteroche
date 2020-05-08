<?php

namespace App\src\services;

class DateFormater
{

    static function formatFR($date)
    {
        setlocale(LC_TIME, "fr_FR");
        return strftime("%a %d %b %G à %Hh%M ", strtotime($date));
    }

    static function formatCondensed($date)
    {
        return date("d-m-Y à H:i", strtotime($date));
    }
}
