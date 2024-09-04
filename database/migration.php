<?php

use Atomir\AtomirCore\Request;

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor/autoload.php";


$app = new \Atomir\AtomirCore\Application(dirname(__DIR__));


switch ($argv[1] ?? false) {
    case '--rollback';
        $app->db->migrations->rollbackMigrations();
        break;
    default:
        $app->db->migrations->applyMigrations();

}