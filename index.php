<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use CoteInfo\Controller\RouteCtl;

$route = new RouteCtl;