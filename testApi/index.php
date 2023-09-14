<?php
require_once './core/Router.php';

$url = $_SERVER['REQUEST_URI'];

$router = new Router($url);
$router->route();
