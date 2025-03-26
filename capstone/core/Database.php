<?php

require_once __DIR__ . '/../includes/config.php';

class Database
{
    public ?\PDO $pdo = null;
    public int $id = 0;
    public int $createdId = 0;
    public int $modifiedId = 0;
    public $lastInsertId = 0;
    public string $sql = "";
    public string $condition = "";
    public string $tableName = '';
    public array $fields = [];
    public array $tempFields = [];

    function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=" . DB_NAME;
        $user = DB_USER;
        $password = DB_PASSWORD;

        try {
            $this->pdo = new \PDO($dsn, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function save()
    {
        $fieldMap = array_map(fn ($field) => ":$field", $this->fields);
        $values = implode(",", $fieldMap);
        $fields = implode(",", $this->fields);

        $this->sql = "INSERT INTO " . $this->tableName . " ($fields) VALUES ($values)";

        $statement = $this->pdo->prepare($this->sql);

        foreach ($this->fields as $field) {
            if (property_exists($this, $field)) {
                $statement->bindValue(":$field", $this->{$field});
            }
        }

        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
             return false;
        }
    }

    public function update()
    {
        $fieldsToUpdate = in_array('createdId', $this->fields) ? Udf::removeKeysArray($this->fields, ['createdId']) : $this->fields;
        $fields = array_map(fn ($field) => "$field=:$field", $fieldsToUpdate);

        $this->sql = "UPDATE " . $this->tableName . " SET " . implode(',', $fields) . $this->condition;

        $statement = $this->pdo->prepare($this->sql);

        foreach ($fieldsToUpdate as $field) {
            if (property_exists($this, $field)) {
                $statement->bindValue(":$field", $this->{$field});
            }
        }

        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
             return false;
        }
    }

    public function delete()
    {
        $this->sql = "DELETE FROM " . $this->tableName . $this->condition;
        $statement = $this->pdo->prepare($this->sql);

        try {
            $this->pdo->beginTransaction();
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
             return false;
        }
    }

    public function fetchAll()
    {
        try {
            $statement = $this->pdo->prepare($this->sql);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
             return false;
        }
    }

    public function fetch()
    {
        try {
            $statement = $this->pdo->prepare($this->sql);
            $statement->execute();
            $results = $statement->fetch(\PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
             return false;
        }
    }
}
