<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*public function dropUser($id) { Lo hizo copilot
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }*/ 

    public function insertUser($data) {
        $query = "INSERT INTO users (username, email, password, name, lastname, telephone, gender, card_number) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['username']);
        $stmt->bindParam(2, $data['email']);
        $stmt->bindParam(3, $data['password']);
        $stmt->bindParam(4, $data['name']);
        $stmt->bindParam(5, $data['lastname']);
        $stmt->bindParam(6, $data['telephone']);
        $stmt->bindParam(7, $data['gender']);
        $stmt->bindParam(8, $data['card_number']);
        return $stmt->execute();
    }
}
?>