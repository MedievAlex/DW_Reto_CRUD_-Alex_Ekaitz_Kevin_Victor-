<?php
class Database
{
    private $host = "localhost";
    private $db_name = "users_manager";
    private $username = "root";
    private $password = "abcd*1234";
    private $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Conection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
