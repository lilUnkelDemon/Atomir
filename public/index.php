<?php

use Atomir\AtomirCore\Application;
use Atomir\AtomirCore\Request;

require_once __DIR__.DIRECTORY_SEPARATOR.".." . DIRECTORY_SEPARATOR . "vendor".DIRECTORY_SEPARATOR."autoload.php";

// Load environment variables from .env file. In development, this file should be.env.development
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR);

// Load environment variables from .env file. In production, this file should be .env.production
$dotenv->load();

$app = new Application(dirname(__DIR__));



$app->router->setRouterFile(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."routes".DIRECTORY_SEPARATOR."web.php");


$app->run();