<?php

namespace App\src\model;

class Article
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $picture;
    private $created_at;
    private $updated_at;

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getContent()
    {
        return $this->content;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }


    public function getAuthor()
    {
        return $this->author;
    }

 
    public function setAuthor($author)
    {
        $this->author = $author;
    }


    public function getCreatedAt($format = null)
    {
       return $this->DateFormat($format, $this->created_at);

    }


    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


    public function getPicture()
    {
        return $this->picture;
    }


    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getUpdatedAt($format = null)
    {
        return $this->DateFormat($format, $this->updated_at);
    }


    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }


    public function DateFormat($format, $date)
    {
        if ($date !== NULL){
            switch ($format){
                case "FR":
                    setlocale(LC_TIME, "fr_FR");
                    return strftime("%a %d %b %G à %Hh%M ", strtotime($date));
                break;
                case "CONDENSED":
                    return date("d-m-Y à H:i", strtotime($date));
                break;
                default: 
                return $date;
            }
        }
    }

}