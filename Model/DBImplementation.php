<?php
require_once 'User.php';

class DBImplementation
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($credential, $password)
    {
        $query = "SELECT * FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID WHERE (p.P_EMAIL = ? OR p.P_USERNAME = ?) AND p.P_PASSWORD = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$credential, $credential, $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
        }

        $query = "SELECT * FROM db_profile p JOIN db_admin a on p.P_ID=a.A_ID WHERE (p.P_EMAIL = ? OR p.P_USERNAME = ?) AND p.P_PASSWORD = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$credential, $credential, $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Admin($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['P_ID']);
        }

        return null;
    }

    public function getUser($id)
    {
        $query = "SELECT * FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID WHERE p.P_ID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
        } else {
            return null;
        }
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
        }

        return $users;
    }

    public function createUser($user)
    {
        $query = "INSERT INTO db_profile (P_EMAIL, P_USERNAME, P_PASSWORD, P_NAME, P_LASTNAME, P_TELEPHONE) VALUES (?, ?, ?, ?, ?, ?);";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getName(),
            $user->getLastname(),
            $user->getTelephone()
        ]);

        $lastInsertId = $this->conn->lastInsertId();

        $query = "INSERT INTO db_user (U_ID, U_GENDER) VALUES (?, ?);";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$lastInsertId, $user->getGender()]);

        $user->setId($lastInsertId);

        return $user;
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM db_profile WHERE P_ID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}
