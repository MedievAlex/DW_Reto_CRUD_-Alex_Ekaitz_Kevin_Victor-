<?php
require_once 'Profile.php';

class ProfileModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function verifyUser(credential, passwd) {
        $query1 = "SELECT * FROM db_profile WHERE (P_EMAIL = ? OR P_USERNAME = ?) AND P_PASSWORD = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1.setString(1, credential);
        $stmt1.setString(2, credential);
        $stmt1.setString(3, passwd);
        $stmt1-> execute();

        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $query2 = "SELECT * FROM db_user JOIN db_profile WHERE P_ID = ?";
          $stmt2 = $this->conn->prepare($query2);
          $stmt2.setString(1, $row1['P_ID']);
          $stmt2-> execute();

          if ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profile = new User(
                $row2['P_EMAIL'], 
                $row2['P_USERNAME'], 
                $row2['P_PASSWORD'], 
                $row2['P_NAME'], 
                $row2['P_LASTNAME'], 
                $row2['P_TELEPHONE'], 
                $row2['U_GENDER'], 
                $row2['U_CARD']);
          }
          else
          {
            $profile = new Admin(
                $row2['P_EMAIL'], 
                $row2['P_USERNAME'], 
                $row2['P_PASSWORD'], 
                $row2['P_NAME'], 
                $row2['P_LASTNAME'], 
                $row2['P_TELEPHONE'], 
                $row2['U_GENDER'], 
                $row2['U_CARD']);
          }
        }
  }
    return $users;
}
?>
