<?php
use App\Config\Router;

require_once __DIR__."/vendor/autoload.php";

$uri = $_SERVER['REQUEST_URI'];
Router::getInstance()->resolve($uri);