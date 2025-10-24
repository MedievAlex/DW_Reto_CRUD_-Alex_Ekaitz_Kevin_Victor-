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

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return false; // Indica un error en la obtención de usuarios
        } else {
            $users = [];
            while ($row = $result) {
                $users[] = new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['U_CARD'], $row['P_ID']);
            }
            return $users;
        }
    }

    public function dropUser($id) {
        $query = "DELETE FROM db_profile WHERE P_ID = :id;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $success = $stmt->execute();

        return $success;
    }
}
?>
