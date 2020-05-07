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


    static function findpictures($article)
    {
        $picture = $article->getPicture();
        $article->setPictureFileName($picture);

        if (file_exists(ARTICLE_THUMB_DIR . $picture) && $picture != NULL) {
            $article->setThumbail(ARTICLE_THUMB_DIR . $picture);
            $article->setPicture(ARTICLE_IMG_DIR . $picture);
        } else {
            $article->setThumbail(DEFAULT_ARTICLE_IMG);
            $article->setPicture(DEFAULT_ARTICLE_IMG);
        }
    }
}
