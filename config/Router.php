<?php

namespace App\config;
use App\src\controller\FrontController;
use App\src\controller\ErrorController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }


    public function run()
    {
        try{
            if(isset($_GET['route']))
            {
                switch ($_GET['route']) {
                    case "home": $this->frontController->home();
                    break;
                    case "auteur": $this->frontController->auteur();
                    break;
                    case "inscription": $this->frontController->register();
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