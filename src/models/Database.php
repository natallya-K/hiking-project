<?php

namespace Models;
require_once 'config.php';

use PDO;
use PDOStatement;
use Exception;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB . ";port=" . PORT, LOGIN, PASSWORD);

            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function query(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => &$val) {
            if (is_int($val)) {
                $stmt->bindParam($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $val);
            }
        }

        $stmt->execute();

        return $stmt;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}
