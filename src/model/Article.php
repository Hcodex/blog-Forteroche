<?php

namespace App\src\model;

class Article
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $picture;
    private $thumbail;
    private $picture_file_name;
    private $created_at;
    private $updated_at;
    private $status;

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

    public function getPictureFileName()
    {
        return $this->picture_file_name;
    }


    public function setPictureFileName($picture_file_name)
    {
        $this->picture_file_name = $picture_file_name;
    }

    public function getPicture()
    {
        return $this->picture;
    }


    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getThumbail()
    {
        return $this->thumbail;
    }


    public function setThumbail($thumbail)
    {
        $this->thumbail = $thumbail;
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

    public function setStatus($status)
    {
        switch ($status){
            case "0":
                $this->status = "brouillon";
            break;
            case "1":
                $this->status = "publié";
            break;
            case "2":
                $this->status = "A relire";
            break;
        }
    }

    public function getStatus()
    {
        return $this->status;
    }



}