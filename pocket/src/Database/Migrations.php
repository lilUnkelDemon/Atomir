<?php

namespace Atomir\AtomirCore\Database;

use Atomir\AtomirCore\Application;

class Migrations
{
    public function __construct(public Database $db)
    {
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();

        $appliedMigrations = $this->getAppliedMigrations();
        $appliedMigrations = array_map(fn($migrations) => $migrations->migrations, $appliedMigrations);

        $files = scandir(Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations');

        $newMigrations = [];

        $migrations = array_diff($files, $appliedMigrations);


        foreach ($migrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            $migrateInstance = require_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $migration;

            $this->log("Applying migration $migration");
            $migrateInstance->up();
            $this->log("applied migration $migration");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {

            $this->saveMigrations($newMigrations);

        } else {
            $this->log("There are no migrations to apply");
        }

    }

    public function rollbackMigrations()
    {
        $appliedMigrations = $this->getAppliedMigrations();
        $lastBatch = $this->getLastBatchOfMigrations();


        $mustRollbackMigrations = array_filter($appliedMigrations, fn($migrations) => $migrations->batch === $lastBatch);


        foreach ($mustRollbackMigrations as $migration) {
            $migrateInstance = require_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $migration->migrations;

            $this->log("rolling back migration {$migration->migrations}");
            $migrateInstance->down();
            $this->log("rolled back migration {$migration->migrations}");
        }

        if (!empty($mustRollbackMigrations)) {
            $this->deleteMigrations(array_map(fn($migrations) => $migration->id, $mustRollbackMigrations));
        } else {
            $this->log("There are no migrations to rollback");
        }

    }

    public function createMigrationsTable()
    {
        $this->db->pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `migrations` VARCHAR(255),
    `batch` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB;");
    }


    protected function saveMigrations($newMigrations): void
    {
        $batchNumber = $this->getLastBatchOfMigrations() + 1;

        $rows = implode(',', array_map(fn($migration) => "( '$migration' , $batchNumber)", $newMigrations));

        $this->db->pdo->exec("INSERT INTO `migrations` (`migrations`, `batch`) VALUES $rows");
    }

    protected function deleteMigrations($migrationsID)
    {
        $ids = implode(',', $migrationsID);
        $this->db->pdo->exec("DELETE FROM `migrations` WHERE `id` IN ({$ids})");


    }

    protected function getAppliedMigrations(): ?array
    {
        $statement = $this->db->pdo->prepare("SELECT `id`,migrations,batch FROM `migrations`");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);


    }

    protected function getLastBatchOfMigrations(): int
    {
        $statement = $this->db->pdo->prepare("SELECT MAX(batch) as max FROM `migrations`");
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_COLUMN) ?? 0;
    }

    private function log($message): void
    {
        $time = date("Y-m-d H:i:s");

        echo "[$time] - $message" . PHP_EOL;

    }

}

