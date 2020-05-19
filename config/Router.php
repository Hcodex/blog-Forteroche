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
                    case "deleteArticle":
                        $this->backController->deleteArticle($this->request->getGet()->get('articleId'));
                    break;
                    case "editProfile":
                        $this->backController->editProfile($this->request->getPost());
                    break;
                    case "addComment":
                        $this->frontController->addComment($this->request->getPost(), $this->request->getGet()->get('articleId'));
                    break;
                    case "editComment":
                        $this->frontController->editComment($this->request->getPost(), $this->request->getGet()->get('articleId'));
                    break;
                    case "reportComment":
                        $this->frontController->reportComment($this->request->getGet()->get('commentId'));
                    break;
                    case "approveComment":
                        $this->backController->approveComment($this->request->getGet()->get('commentId'));
                    break;
                    case "deleteComment":
                        $this->backController->deleteComment($this->request->getGet()->get('commentId'));
                    break;
                    case "archiveComment":
                        $this->backController->archiveComment($this->request->getGet()->get('commentId'));
                    break;
                    case "hideComment":
                        $this->backController->hideComment($this->request->getGet()->get('commentId'));
                    break;
                    case "ajax":
                        $this->uploadController->_ajaxUpload($this->request->getPost());
                    break;
                    case "ajaxFilesDelete":
                        $this->uploadController->_ajaxFilesDelete($this->request->getPost());
                    break;
                    case "setRole":
                        $this->backController->setRole($this->request->getGet()->get('userId'),$this->request->getGet()->get('role'));
                    break;
                    case "banUser":
                        $this->backController->banUser($this->request->getGet()->get('userId'));
                    break;
                    case "unbanUser":
                        $this->backController->unbanUser($this->request->getGet()->get('userId'));
                    break;
                    case "confirmAccount":
                        $this->frontController->confirmAccount($this->request->getGet());
                    break;
                    case "requestToken":
                        $this->frontController->requestToken($this->request->getPost());
                    break;
                    case "requestAccountRecovery":
                        $this->frontController->requestAccountRecovery($this->request->getPost());
                    break;
                    case "accountRecovery":
                        $this->frontController->accountRecovery($this->request->getPost());
                    break;
                    case "passwordModify":
                        $this->frontController->passwordModify($this->request->getPost());
                    break;
                    case "setBookmark":
                        $this->frontController->setBookmark($this->request->getGet()->get('articleId'));
                    break;
                    case "deleteUser":
                        $this->backController->deleteUser($this->request->getGet()->get('userId'));
                    break;
                    case "mentionsLegales":
                        $this->frontController->mentions();
                    break;
                    case "politiqueConfidentialite":
                        $this->frontController->politique();
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