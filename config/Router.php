<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\BackController;
use App\src\controller\ErrorController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;
    private $backController;
    private $request;


    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
    }


    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try{
            if(isset($route))
            {
                switch ($route) {
                    case "home":
                         $this->frontController->home();
                    break;
                    case "auteur":
                         $this->frontController->auteur();
                    break;
                    case "inscription":
                         $this->frontController->register($this->request->getPost());
                    break;
                    case "login":
                        $this->frontController->login($this->request->getPost());
                    break;
                    case "logout":
                        $this->backController->logout();
                    break;
                    case "profile":
                        $this->backController->profile();
                    break;
                    case "administration":
                        $this->backController->administration();
                    break;
                    default:$this->errorController->errorNotFound();
                }
            }
            else{
                $this->frontController->home();
            }
        }
        catch (Exception $e)
        {
            $this->errorController->errorServer();
        }
    }
}