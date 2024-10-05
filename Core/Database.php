<?php

namespace Core;
use PDO;
use Core\ResponseCode;
use Core\Response;



class Database
{
    public $conn;
    public $statement;
    public function __construct($config, $username = 'postgres', $password = 'Russeldc189')
{   
    // Construct the DSN without charset
    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
    
    try {
        // Remove charset from the options array
        $this->conn = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Optional: to throw exceptions for errors
        ]);
        // Optionally set client encoding
        $this->conn->exec("SET NAMES 'utf8'");
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}

    
    public function query($query, $params = [])
    {
        $this->statement = $this->conn->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function find($table, $id)
    {
        $this->statement = $this->conn->prepare("SELECT * FROM $table WHERE id = ?");
        $this->statement->execute([$id]);
        return $this->fetch();
    }

    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $this->statement = $this->conn->prepare("INSERT INTO $table ($columns) VALUES ($values)");
        $this->statement->execute(array_values($data));
        return $this->conn->lastInsertId();
    }

    public function update($table, $data, $id)
    {
        $columns = implode('=?,', array_keys($data)).'=?';
        $this->statement = $this->conn->prepare("UPDATE $table SET $columns WHERE id = ?");
        $this->statement->execute(array_merge(array_values($data), [$id]));
        return $this->statement->rowCount();
    }

    public function findbyColumn($table, $column, $id)
    {
        $this->statement = $this->conn->prepare("SELECT * FROM $table WHERE $column = ?");
        $this->statement->execute([$id]);
        return $this->fetch();
    }

    public function unique($table, $column, $value)
    {
        $this->statement = $this->conn->prepare("SELECT * FROM $table WHERE $column = ?");
        $this->statement->execute([$value]);
        return $this->fetch();
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function fetch()//find
    {
        return $this->statement->fetch();
    }
    public function fetchorFail()
    {
        $result = $this->fetch();
        if(!$result)
        {
            Response::json(['message' => 'Record not found'],ResponseCode::NOT_FOUND);
        }
        return $result;
    }
 

}



?>