<?php

namespace Infra;

use PDO;
use PDOException;

abstract class Orm
{
    protected PDO $pdo;
    protected string $tableName;
    protected string $primaryKey = 'id';

    public function __construct(string $tableName)
    {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->tableName = $tableName;
    }

    /**
     * Récupérer tous les enregistrements dans une base de donnée
     * @return array
     */
    protected function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->tableName}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un enregistrement dans la base de donnée à partir de son id
     * @param string $id
     * @return array|null
     */
    protected function find(string $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Créer un enregistrement dans la base de donnée
     * @param array $data
     * @return bool
     */
    protected function create(array $data): bool
    {
        $columns = array();
        foreach (array_keys($data) as $key)
        {
            $columns[] = $this->convertPropertyName($key);
        }
        $columns = implode(', ', $columns);
        $placeholders = array();
        foreach ($data as $key => $value)
        {
            $placeholders[] = ":{$key}";
        }
        $placeholders = implode(', ', $placeholders);
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})");
        return $stmt->execute($this->prepareData($data));
    }

    /**
     * Mettre à jour un enregistrement dans la base de donnée
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $set = array();
        foreach ($data as $key => $value)
        {
            $set[] = $this->convertPropertyName($key) . " = :{$key}";
        }
        $set = implode(', ', $set);
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET {$set} WHERE {$this->primaryKey} = :id");
        $stmt->execute(array_merge(['id' => $id], $this->prepareData($data)));
        return $stmt->rowCount() > 0;
    }

    /**
     * Supprimer un enregistrement dans la base de donnée
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Préparer les données avant l'insertion ou la mise à jour
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        foreach ($data as $key => $value)
        {
            if($value instanceof \DateTime)
            {
                $data[$key] = $value->format('Y-m-d H:i:s');
            }
        }
        return $data;
    }

    /**
     * Convertir les noms de propriétés en snake case
     * @param string $name
     * @return string
     */
    private function convertPropertyName(string $name): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
    }
}