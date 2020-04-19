<?php

namespace App\src\controller;

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
    public function register()
    {
        return $this->view->render('register');
    }
}