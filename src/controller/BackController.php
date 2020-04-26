<?php

namespace App\src\controller;

use App\config\Parameter;

class BackController extends Controller
{

    private function checkLoggedIn()
    {
        if(!$this->session->get('pseudo')) {
            $this->session->set('error_message', 'Vous devez vous connecter pour accéder à cette page');
            header('Location: ../public/index.php?route=login');
        } else {
            return true;
        }
    }


    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if(!($this->session->get('role') === 'admin')) {
            $this->session->set('error_message', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: ../public/index.php?route=profile');
        } else {
            return true;
        }
    }

    public function administration()
    {
        if($this->checkAdmin()) {       
            $articles = $this->articleDAO->getArticles();
           
            return $this->view->render('administration', [
                'articles' => $articles,
            ]);   
        }
    }

    public function addArticle(Parameter $post)
    {
        if($this->checkAdmin()) {
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Article');
                if (!$errors) {
                    $this->articleDAO->addArticle($post, $this->session->get('id'));
                   /* $this->session->set('add_article', 'Le nouvel article a bien été ajouté');*/
                    $this->session->set('success_message', '<Strong>Articlé créé avec succès !</strong>');
                    header('Location: ../public/index.php?route=administration');
                }
                else{
                $this->session->set('error_message', '<Strong>Erreur ! </strong> L\'article n\'a pas été crée');
                return $this->view->render('add_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
                }
            }
            else{
            return $this->view->render('add_article');
            }
        }
    }


    public function profile()
    {
        if($this->checkLoggedIn()) {
            return $this->view->render('profile');
        }
    }

    public function logout()
    {
        if($this->checkLoggedIn())
        {
            $this->logoutOrDelete('logout');    
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


}