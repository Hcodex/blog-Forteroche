<?php

namespace App\src\controller;

use App\config\Request;
use App\src\DAO\UserDAO;
use App\src\DAO\ArticleDAO;
use App\src\model\View;
use App\src\constraint\Validation;

abstract class Controller
{ 
    public function __construct()
    {
        $this->view = new View();
        $this->validation = new Validation();
        $this->userDAO = new UserDAO();
        $this->request = new Request();
        $this->userDAO = new UserDAO();
        $this->articleDAO = new ArticleDAO();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }
}