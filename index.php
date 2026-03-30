<?php
require __DIR__ . '/app/config/config.php';
require ROOT . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

use CoteInfo\Controller\Route;

$route = new Route;
$route->redirigeVers();