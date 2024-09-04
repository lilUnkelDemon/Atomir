<?php

use Atomir\AtomirCore\Application;

return new class {


    public function up()
    {

        $sql = "ALTER TABLE `user` ADD COLUMN `password` varchar(255) NOT NULL";

        Application::$app->db->pdo->exec($sql);

    }

    public function down()
    {
        $sql = "ALTER TABLE `user` drop COLUMN `password`";
        Application::$app->db->pdo->exec($sql);
    }

};