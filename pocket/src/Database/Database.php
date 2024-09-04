<?php namespace Atomir\AtomirCore\Database;

use PDO;

class Database
{
    public PDO $pdo;
    public Migrations $migrations;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", "{$_ENV['DB_USER']}", "{$_ENV['DB_PASS']}");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->migrations = new Migrations($this);

    }
}