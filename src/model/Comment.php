<?php

namespace App\src\model;

class Comment
{
    private $id;
    private $user_id;
    private $content;
    private $created_at;
    private $reported;
    private $pseudo;
    private $avatar;
    private $article_id;

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getUser()
    {
        return $this->user_id;
    }


    public function setUser($user_id)
    {
        $this->user_id = $user_id;
    }


    public function getContent()
    {
        return $this->content;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function isReported()
    {
        return $this->reported;
    }

    public function setReported($reported)
    {
        $this->reported = $reported;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getArticleId()
    {
        return $this->article_id;
    }

    public function setArticleId($article_id)
    {
        $this->article_id= $article_id;
    }

}