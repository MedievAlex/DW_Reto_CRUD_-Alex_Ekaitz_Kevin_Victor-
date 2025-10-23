<?php
require_once 'User.php';

class AdminModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = "SELECT p.P_ID, p.P_EMAIL, p.P_USERNAME, p.P_PASSWORD, p.P_NAME, p.P_LASTNAME, p.P_TELEPHONE, u.U_GENDER, u.U_CARD
                    FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['U_CARD'], $row['P_ID']);
        }
        return $users;
    }

    public function dropUser() {
        $query = "SELECT p.P_ID, p.P_EMAIL, p.P_USERNAME, p.P_PASSWORD, p.P_NAME, p.P_LASTNAME, p.P_TELEPHONE, u.U_GENDER, u.U_CARD
                    FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['U_CARD'], $row['P_ID']);
        }
        return $users;
    }
    /*public function buscarPorIsbn($isbn) {
        $query = "SELECT * FROM libros WHERE isbn = :isbn";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Libro($row['isbn'], $row['nombre'], $row['autor']);
        } else {
            return null;
        }
    }*/

    /*public function borrarPorIsbn($isbn){
        $query = "DELETE FROM libros WHERE isbn = :isbn";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            return new Libro($row['isbn'], $row['nombre'], $row['autor']);
        } else {
            return null;
        }
    }*/
}
?>
