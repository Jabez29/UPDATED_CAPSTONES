<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Udf.php';

class Users extends Database
{
    public string $firstName = '';
    public string $middleName = '';
    public string $lastName = '';
    public string $userName = '';
    public string $email = '';
    public string $password = '';

    function __construct()
    {
        parent::__construct();
        $this->fields = [
            'firstName', 'middleName', 'lastName', 'userName', 'email', 
        ];
        $this->tableName = 'login_systems';
    }

    function list()
    {
        $fields = implode(",", Udf::removeKeysArray($this->fields, ['modifiedId', 'createdId']));
        $this->sql = "SELECT id, $fields FROM " . $this->tableName;
        return $this->fetchAll();
    }

    function read()
    {
        $fields = implode(",", Udf::removeKeysArray($this->fields, ['modifiedId', 'createdId']));
        $this->sql = "SELECT id, $fields FROM " . $this->tableName . " WHERE id=" . $this->id;
        return $this->fetch();
    }

    public function save()
    {
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

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
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

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

    public function verifyPassword(string $inputPassword): bool
    {
        return password_verify($inputPassword, $this->password);
    }
}