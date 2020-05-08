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

    static function findCommentsPictures($comments)
    {
        foreach ($comments as $comment) {
            $userId = $comment->getUser();
            $picture = $comment->getAvatar();
            if (file_exists(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture) && $picture != NULL) {
                $comment->setAvatar(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture);
            } else {
                $comment->setAvatar(DEFAULT_AVATAR_IMG);
            }
        }
    }

    static function findAvatar($user)
    {
        $userId = $user->getId();
        $picture = $user->getAvatar();
        if (file_exists(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture) && $picture != NULL) {
            $user->setAvatarSrc(AVATAR_IMG_DIR . $userId .'/' . $picture);
            $user->setThumbail(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture);
        } else {
            $user->setAvatarSrc(DEFAULT_AVATAR_IMG);
            $user->setThumbail(DEFAULT_AVATAR_IMG);
        }
    }

    static function findAvatars($users)
    {
        foreach ($users as $user) {
        $userId = $user->getId();
        $picture = $user->getAvatar();
        if (file_exists(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture) && $picture != NULL) {
            $user->setAvatarSrc(AVATAR_IMG_DIR . $userId .'/' . $picture);
            $user->setThumbail(AVATAR_IMG_DIR . $userId . '/thumb/' . $picture);
        } else {
            $user->setAvatarSrc(DEFAULT_AVATAR_IMG);
            $user->setThumbail(DEFAULT_AVATAR_IMG);
        }
    }
    }
}
