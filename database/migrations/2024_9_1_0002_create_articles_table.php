<?php

use Atomir\AtomirCore\Application;

return new class {


    public function up()
    {

        $sql = "CREATE TABLE `articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

        Application::$app->db->pdo->exec($sql);

    }

    public function down()
    {
        $sql = "DROP TABLE `articles`";
        Application::$app->db->pdo->exec($sql);
    }

};