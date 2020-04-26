<?php

namespace App\src\controller;

use App\config\Parameter;

class FrontController extends Controller
{


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
                header('Location: ../public/index.php?route=profile');
            }
            else {
                $this->session->set('error_login', 'Le pseudo et/ou le mot de passe sont incorrects');
                $this->session->set('error_message', '<Strong>Echec connexion ! </strong> Le pseudo et/ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'post'=> $post,
                ]);
            }
        }
        else {
        return $this->view->render('login');
        }
    }
}