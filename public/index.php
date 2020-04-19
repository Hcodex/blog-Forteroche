<?php
require '../config/dbConnect.php';
require '../vendor/autoload.php';
session_start();
$router = new \App\config\Router();
$router->run();