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
            return $this->view->render('administration', [
            ]);   
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