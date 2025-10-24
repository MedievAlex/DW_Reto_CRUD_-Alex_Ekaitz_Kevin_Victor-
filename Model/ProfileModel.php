<?php
require_once 'Profile.php';

class ProfileModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function verifyUser() {
        $query = "SELECT * FROM db_profile WHERE P_USERNAME = ? AND P_PASSWORD = ?";
        $stmt = $this->conn->prepare($query);
        $stmt.setString(1, user.getUsername());
        $stmt.setString(1, user.getUsername());
        $stmt-> execute();

        $rs = $stmt.executeQuery();
        $rs.close();
        $stmt.close();

        if ($rs.next()) {
              $user = new User(
                $row['P_EMAIL'], 
                $row['P_USERNAME'], 
                $row['P_PASSWORD'], 
                $row['P_NAME'], 
                $row['P_LASTNAME'], 
                $row['P_TELEPHONE'], 
                $row['U_GENDER'], 
                $row['U_CARD']);
              }
            }

        return $users;
    }
}
?>
