<?php

// https://www.php.net/manual/en/language.oop5.properties.php
require_once 'config.php';
class DatabaseUtility
{
public ?PDO $pdo = null; // https://www.php.net/manual/en/class.pdo.php PDO object for database connection
private ?PDOStatement $_last_prepared = null;

    function __construct(string $dsn, string $username, string $password )
    {
        if (IS_DEBUG) {echo "new DatabaseUtility started<br>";}
        try {
            $this->pdo = new PDO($dsn, $username, $password );
        } catch (PDOException $e) { echo 'error'.$e ;}

    }

    public static function add_user(array $params) {

    }

    public function prepare(string $statement): array
    {
        if (IS_DEBUG) {echo "DatabaseUtility prepare<br>";}
        $results = [0, 'unknown error'];
        $this->_last_prepared = $this->pdo->prepare($statement);
        $results = [1, 'worked'];
        return $results;
    }
    public function execute(array $param): array
    {
        if (IS_DEBUG) {echo "DatabaseUtility execute<br>";}
        $results = [0, 'unknown error'];
        $this->_last_prepared->execute($param);
        $results = [1, 'worked'];
        return $results;
    }

    public function add_entry(string $table, array $params) : array {
        if (IS_DEBUG) {echo "DatabaseUtility::add_entry table: $table, params: "; var_dump($params); echo "<br>";}
        $results = [0, "unknown"];
        $statement = "INSERT INTO $table  ( ".join(', ', array_keys($params))." ) VALUES ( :".join(', :', array_keys($params))." )";
        if (IS_DEBUG) {echo "statement: $statement";}
        $this->_last_prepared = $this->pdo->prepare($statement);
        $this->execute($params);
        $results = [1, "row added"];
        return $results;
    }

}