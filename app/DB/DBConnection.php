<?php


namespace App\DB;

use PDO;
use PDOException;

class DBConnection
{
    private $connection;

    private function __construct()
    {
        try {
            $this->connection = new PDO('mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
        } catch (PDOException $e) {
            //Database does not exist
            if($e->getCode() == 1049 || $e->getCode() == 1045) {
                redirect('/install')->send();
            }
        }
    }

    public function checkExist($table, $fields): bool
    {
        if(count($fields) == 0) {
            return false;
        }

        $keys = array_keys($fields);

        $first_key = $keys[0];
        $first_field = $fields[$keys[0]];

        $query = "SELECT 1 from $table  WHERE $first_key = '$first_field' ";

        array_shift($fields);

        foreach ($fields as $key => $field) {
            $query .= "AND $key = '$field' ";
        }

        $query .= ";";

        $results = $this->exec($query);

        return count($results) > 0;
    }

    public function create($table, $fields)
    {
        if(count($fields) == 0) {
            return false;
        }
        $columns = "";
        $values = "";

        foreach ($fields as $key => $field) {
            $columns .= "$key,";
            $values .= "'$field',";
        }

        $columns = substr($columns, 0, strlen($columns) - 1);
        $values = substr($values, 0, strlen($values) - 1);

        $query = "INSERT INTO $table ($columns) VALUES ($values);";

        $this->exec($query);

        $last_id = $this->connection->lastInsertId();

        return (int) $last_id;
    }

    public function findOrFail($table, $id)
    {
        $query = "SELECT * FROM $table WHERE id = '$id';";

        $result = $this->exec($query);

        if(count($result) == 0) {
            abort(404);
        }

        return $result[0];
    }

    public function all($table, $select = '*')
    {
        $query = "SELECT $select FROM $table ;";

        return $this->exec($query);
    }

    public function hasMany($table, $join_table, $foreign_table, $id)
    {
        $query = "select $table.* from $table
                    join $join_table 
                        on $table.id = $join_table.{$table}_id
                    join $foreign_table
                        on $join_table.{$foreign_table}_id = $foreign_table.id 
                where $foreign_table.id = $id";

        return $this->exec($query);
    }

    public function get($table, $fields)
    {
        if(count($fields) == 0) {
            return;
        }

        $keys = array_keys($fields);

        $first_key = $keys[0];
        $first_field = $fields[$keys[0]];

        $query = "SELECT * from $table  WHERE $first_key = '$first_field' ";

        array_shift($fields);

        foreach ($fields as $key => $field) {
            $query .= "AND $key = '$field' ";
        }

        $query .= ";";

        $result = $this->exec($query);

        return $result;
    }

    public function update($table, $id, $fields)
    {
        if(count($fields) == 0) {
            return false;
        }

        $query = "UPDATE $table SET ";

        foreach ($fields as $key => $field) {
            $query .= "$key = '$field',";
        }

        $query = substr($query, 0, strlen($query) - 1);
        $query .= " WHERE id = '$id';";

        return $this->exec($query);
    }

    public function delete($table, $id)
    {
        $query = "DELETE FROM $table WHERE id = '$id';";

        $this->exec($query);
    }

    public function deleteWhere($table, $fields)
    {
        if(count($fields) == 0) {
            return;
        }

        $keys = array_keys($fields);

        $first_key = $keys[0];
        $first_field = $fields[$keys[0]];

        $query = "DELETE FROM $table WHERE $first_key = '$first_field' ";

        array_shift($fields);

        foreach ($fields as $key => $field) {
            $query .= "AND $key = '$field' ";
        }

        $query .= ";";

        $this->exec($query);
    }

    public function getColumns($table)
    {
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table';";

        return $this->exec($query, PDO::FETCH_COLUMN);
    }

    public function exec($query, $fetch_type = PDO::FETCH_ASSOC)
    {
        $sth = $this->connection->prepare($query);
        $statement = $sth->execute();

        if(!$statement) {
            dd($sth->errorInfo());
        }

        return $sth->fetchAll($fetch_type);
    }

    public static function instantiate()
    {
        return new DBConnection();
    }

    public static function installDB($user, $pass)
    {
        try {
            $pdo = new PDO('mysql:host=' . env('DB_HOST'), $user, $pass);

            $query = file_get_contents(__DIR__ . "/../../database/db.sql");

            $execution = $pdo->prepare($query);

            $execution->execute();

            $pdo = null;
        } catch (PDOException $e) {
            dd($e);
        }
    }
}
