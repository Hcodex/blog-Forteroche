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
        $this->userDAO = new UserDAO();
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
            if($this->userDAO->checkUserPseudo($post)) {
                $errors['pseudo'] = $this->userDAO->checkUserPseudo($post);
            }
            if($this->userDAO->checkUserEmail($post)) {
                $errors['email'] = $this->userDAO->checkUserEmail($post);
            }
            if(!$errors) {
                $success = $this->userDAO->register($post);
            }
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors,
                'success' => $success
            ]);
        }
        return $this->view->render('register');
    }
}