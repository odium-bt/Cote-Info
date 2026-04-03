<?php
require __DIR__ . '/config/config.php';
require ROOT . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

use CoteInfo\Controller\Route;

session_start();

$route = new Route;
$route->redirigeVers();