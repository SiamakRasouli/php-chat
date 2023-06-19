<?php

namespace app;
use PDO;

class Database {
    public $server;
    public $username;
    public $password;
    public $db_name;
    public $port;
    protected $conn;

    function __construct()
    {
        $this->server = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->db_name = "phpchat";
        $this->port = 3306;
        
        $this->connect();
    }

    function connect() {
        $dsn = "mysql:host={$this->server};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
        $this->conn = new PDO($dsn, $this->username, $this->password);
    }

    function query($query, $params = []) {
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    function select($table, $where = NULL, $limit =1, $offset = 0) {
        $query = "SELECT * FROM {$table}";

        if($where !== NULL) {
            $key = key($where); // grab first key from $where array
            $value = reset($where);  // grab first element from $where array
            $query .= " WHERE {$key} = '{$value}'";
            $where = array_slice($where,1); // delete first element of array

            foreach($where as $key => $value) {
                $query .= "  AND {$key} = '{$value}'"; // add rest of $where data to query
            }

            $query .= " ORDER BY id DESC";
            $query .= " LIMIT {$offset}, {$limit}";

            return $this->query($query)->fetchAll();
        }
    }


    function update($table, $data) {
        $columns = implode(',', array_keys($data));
        $values = implode(',', $this->replace_array_values($data));

        $query = "REPLACE INTO {$table} WHERE ({$columns}) VALUES ({$values})";
        return $this->query($query, array_values($data));
    }

    function delete($table, $data) {
        $query = "DELETE FROM {$table} WHERE {array_keys($data)} = ?";
        return $this->query($query, array_values($data));
    }

    function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $values = implode(',', $this->replace_array_values($data));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        $data = $this->query($query, array_values($data));
        return $data;
    }

    //This function will create array with value fo ? sign as much as columns count!
    function replace_array_values($array) {
        foreach($array as $key => $value) {
            $array[$key] = '?';
        }
        return $array;
    }
}