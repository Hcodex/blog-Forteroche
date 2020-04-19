<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;
use App\src\model\View;
use App\src\constraint\Validation;

class FrontController
{

    public function __construct()
    {
        $this->view = new View();
        $this->validation = new Validation();
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
            $errors = $this->validation->validate($post, 'User');
            if(!$errors) {
            $userDAO = new UserDAO();
            $userDAO->register($post);
            }
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('register',[
            'post' => $post
        ]);
    }
}