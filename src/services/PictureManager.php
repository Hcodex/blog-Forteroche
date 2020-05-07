<?php

namespace App\src\services;

class PictureManager
{
    static function findArticlePictures($article)
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

    static function findArticlesPictures($articles)
    {
        foreach ($articles as $article) {
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
}
