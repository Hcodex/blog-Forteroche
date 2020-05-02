<?php

namespace App\src\model;

class User
{
    private $id;
    private $pseudo;
    private $email; 
    private $password;
    private $created_at;
    private $role;
    private $avatar;
    private $thumbail;
    private $avatar_file_name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getRole()
    {
        return $this->role;
    }

  
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getAvatarFileName()
    {
        return $this->avatar_file_name;
    }


    public function setAvatarFileName($avatar_file_name)
    {
        $this->avatar_file_name = $avatar_file_name;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }


    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getThumbail()
    {
        return $this->thumbail;
    }


    public function setThumbail($thumbail)
    {
        $this->thumbail = $thumbail;
    }


}