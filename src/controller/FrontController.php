<?php

namespace App\src\controller;

use App\config\Request;
use App\src\DAO\UserDAO;
use App\src\model\View;
use App\src\constraint\Validation;
use App\config\Parameter;

class FrontController
{
    public function __construct()
    {
        $this->view = new View();
        $this->validation = new Validation();
        $this->userDAO = new UserDAO();
        $this->request = new Request();
        $this->userDAO = new UserDAO();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }

    public function home()
    {
        return $this->view->render('home');
    }

    public function auteur()
    {
        return $this->view->render('auteur');
    }

    public function register(Parameter $post)
    {
        if($post->get('submit')) {
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

    public function login(Parameter $post)
    {
        if($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if($result && $result['isPasswordValid']) {
                $this->session->set('login', 'Bonne lecture');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('email', $post->get('email'));
                $this->session->set('pseudo', $result['result']['pseudo']);
                $this->session->set('avatar', $result['result']['avatar']);
                $this->session->set('success_message', '<Strong>Connexion réussie ! </strong> Bonne lecture');
            }
            else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Le pseudo et/ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'post'=> $post,
                ]);
            }
        }
        header('Location: ../public/index.php?route=profile');
    }

    public function logout()
    {
        if($this->checkLoggedIn())
        {
            $this->logoutOrDelete('logout');    
        }
    }

    private function checkLoggedIn()
    {
        if(!$this->session->get('pseudo')) {
            $this->session->set('error_message', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: ../public/index.php?route=login');
        } else {
            return true;
        }
    }

    private function logoutOrDelete($param)
    {
        $this->session->stop();
        $this->session->start();
        if($param === 'logout') {
            $this->session->set($param, 'Vous avez été correctement déconnecté, a bientôt.');
            $this->session->set('success_message', 'Vous avez été correctement déconnecté, a bientôt.');
        } else {
            $this->session->set($param, 'Votre compte a bien été supprimé');
        }
        header('Location: ../public/index.php');
    }

    public function profile()
    {
        if($this->checkLoggedIn()) {
            return $this->view->render('profile');
        }
    }
}