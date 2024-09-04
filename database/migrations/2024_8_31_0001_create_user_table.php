<?php

use Atomir\AtomirCore\Application;

return new class {


    public function up()
    {

        $sql = "CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `create_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

        Application::$app->db->pdo->exec($sql);

    }

    public function down()
    {
        $sql = "DROP TABLE `user`";
        Application::$app->db->pdo->exec($sql);
    }

};