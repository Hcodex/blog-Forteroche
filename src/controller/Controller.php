<?php

namespace App\src\controller;

use App\config\Request;
use App\src\DAO\UserDAO;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
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
        $this->commentDAO = new CommentDAO();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }

    public function checkLoggedIn()
    {
        if (!$this->session->get('pseudo')) {
            $this->session->set('error_message', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: index.php?route=login');
            exit();
        } else {
            return true;
        }
    }
}