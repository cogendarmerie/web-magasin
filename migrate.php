<?php
require_once 'autoload.php';
require_once 'vendor/autoload.php';

class Migrator
{
    protected \PDO $pdo;
    protected $migrations = [];

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->loadMigrations();
    }

    public function loadMigrations(): void
    {
//        $files = glob(__DIR__.'/migrations/*.php');
//        foreach ($files as $file)
//        {
//            $className = pathinfo($file, PATHINFO_FILENAME);
//            $className = str_replace('_', '', $className);
//            $className = ucwords($className);
//            $className = str_replace(' ', '', $className);
//            require_once $file;
//            $this->migrations[] = new $className($this->pdo);
//        }

        $this->migrations[] = new \migrations\CreateProductTable($this->pdo);
        $this->migrations[] = new \migrations\CreateCustomerTable($this->pdo);
        $this->migrations[] = new \migrations\CreateOrderTable($this->pdo);
    }

    public function up(): void
    {
        foreach ($this->migrations as $migration) {
            $migration->up();
        }
    }

    public function down(): void
    {
        $migrations = array_reverse($this->migrations);
        foreach ($migrations as $migration)
        {
            $migration->down();
        }
    }
}

// Connexion à la base de donnée
$pdo = new PDO('mysql:host=db;dbname=mag', 'mag', 'mag');

// Exécuter les migrations
$migrator = new Migrator($pdo);
$migrator->up();