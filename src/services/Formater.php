<?php

namespace App\src\services;

class Formater
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

    static function setStatusIcon($status)
    {
        switch ($status) {
            case "0":
                return '<i class="text-danger" data-feather="file-text" data-toggle="tooltip" data-placement="bottom" title="Brouillon"></i>';
                break;
            case "1":
                return '<i class="text-success" data-feather="check-circle" data-toggle="tooltip" data-placement="bottom" title="Publié"></i>';
                break;
            case "2":
                return '<i class="text-warning" data-feather="pen-tool" data-toggle="tooltip" data-placement="bottom" title="A relire"></i>';
                break;
        }
    }
}