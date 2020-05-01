<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\BackController;
use App\src\controller\ErrorController;
use App\src\controller\UploadController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;
    private $backController;
    private $uploadController;
    private $request;


    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
        $this->uploadController = new UploadController();
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
                    case "roman":
                        $this->frontController->roman();
                    break;
                    case "article":
                        $this->frontController->article($this->request->getGet()->get('articleId'));
                    break;
                    case "administration":
                        $this->backController->administration();
                    break;
                    case "addArticle":
                        $this->backController->addArticle($this->request->getPost());
                    break;
                    case "editArticle":
                        $this->backController->editArticle($this->request->getPost(), $this->request->getGet()->get('articleId'));
                    break;
                    case "editProfile":
                        $this->backController->editProfile($this->request->getPost(), $this->request->getSession()->get('id'));
                    break;
                    case "upload":
                        $this->uploadController->upload($this->request->getPost(), $this->request->getGet()->get('upload_mode'));
                    break;
                    case "filesdelete":
                        $this->uploadController->filesDelete($this->request->getPost());
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