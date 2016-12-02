<?php
# 11/13/2016 by Martin Suarez
# This scripts connects to the database and sets the encoding.
# To be included in all subpages.

// Defined as constants for security reasons.
DEFINE( 'DB_USER', 'admin');
DEFINE( 'DB_PASSWORD', 'hello');
DEFINE( 'DB_HOST', 'localhost');
DEFINE( 'DB_NAME', 'forum');

$pdo = new PDOConnection('mysql', DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

class PDOConnection extends PDO
{
    function __construct($dbms_name, $db_host, $db_name, $user, $pass) {
        $dns = "$dbms_name:host=$db_host;dbname=$db_name;charset=utf8";
        try {
            parent::__construct($dns, $user, $pass);
            $this->setAttribute($this::ATTR_ERRMODE, $this::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo 'Connection failed: ' . $exception->getMessage();
        }
    }

    /**
     * @param $sql
     * @param array $parameter
     * @param array $columns
     * @return PDOStatement
     */
    public function query_param($sql, array $parameter, array &$columns = []) {
        try {
            $stmt = $this->prepare($sql);
        } catch (PDOException $e) {
            echo 'Error preparing query: ' . $e->getMessage();
            return false;
        }

        foreach ($parameter as $key => $value) {
            try {
                switch (count($value)) {
                    case 1:
                        $res = $stmt->bindParam($key, $value[0]);
                        break;
                    case 2:
                        $res = $stmt->bindParam($key, $value[0], $value[1]);
                        break;
                    case 3:
                        $res = $stmt->bindParam($key, $value[0], $value[1], $value[2]);
                        break;
                    case 4:
                        $res = $stmt->bindParam($key, $value[0], $value[1], $value[2], $value[3]);
                        break;
                    default:
                        throw new PDOException("Error binding parameter $key, wrong number of arguments.");
                        break;
                }
                if (!$res) {
                    throw new PDOException("Error binding parameter $key, one or more invalid arguments.");
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        foreach ($columns as $key => $column) {
            $stmt->bindColumn($key, $column);
        }
        $stmt->execute();
        return $stmt;
    }
}