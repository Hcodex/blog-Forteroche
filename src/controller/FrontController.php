<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;
use App\src\model\View;

class FrontController
{

    public function __construct()
    {
        $this->view = new View();
    }

    public function home()
    {
        return $this->view->render('home');
    }

    public function auteur()
    {
        return $this->view->render('auteur');
    }

    public function register($post)
    {
        if(isset($post['submit'])) {
            $userDAO = new UserDAO();
            $userDAO->register($post);
        }
        return $this->view->render('register',[
            'post' => $post
        ]);
    }
}