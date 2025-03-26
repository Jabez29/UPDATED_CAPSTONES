<?php

class Database {
    public $pdo;

    public function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}