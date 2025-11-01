<?php
require_once 'User.php';
require_once 'Admin.php';

class DBImplementation
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function findProfileByCredential($credential)
    {
        try {
            $query = "SELECT P_ID, P_EMAIL, P_USERNAME, P_PASSWORD FROM db_profile WHERE P_EMAIL = ? OR P_USERNAME = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$credential, $credential]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error finding profile: " . $e->getMessage());
        }
    }

    private function findProfileByType($profileId)
    {
        try {
            $query = "SELECT * FROM db_profile p JOIN db_user u ON p.P_ID=u.U_ID WHERE p.P_ID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$profileId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
            }

            $query = "SELECT * FROM db_profile p JOIN db_admin a ON p.P_ID=a.A_ID WHERE p.P_ID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$profileId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Admin($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['P_ID']);
        } catch (Exception $e) {
            throw new Exception("Error finding profile type: " . $e->getMessage());
        }
    }

    private function checkCredentialsExistence($email, $username)
    {
        try {
            $query = "SELECT P_EMAIL, P_USERNAME FROM db_profile WHERE P_EMAIL = ? OR P_USERNAME = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$email, $username]);

            $exists = ['email' => false, 'username' => false];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($email === $row['P_EMAIL']) {
                    $exists['email'] = true;
                }
                if ($username === $row['P_USERNAME']) {
                    $exists['username'] = true;
                }
            }
            return $exists;
        } catch (Exception $e) {
            throw new Exception("Error checking credentials: " . $e->getMessage());
        }
    }

    public function login($credential, $password)
    {
        try {
            $profile = $this->findProfileByCredential($credential);
            if (!$profile) {
                return null;
            }

            if ($profile['P_PASSWORD'] !== $password) {
                return null;
            }

            return $this->findProfileByType($profile['P_ID']);
        } catch (Exception $e) {
            throw new Exception("Login error: " . $e->getMessage());
        }
    }

    public function createUser($user)
    {
        try {
            $existing = $this->checkCredentialsExistence($user->getEmail(), $user->getUsername());

            if ($existing['email'] && $existing['username']) {
                throw new Exception("Both email and username already exists");
            } elseif ($existing['email']) {
                throw new Exception("Email already exists");
            } elseif ($existing['username']) {
                throw new Exception("Username already exists");
            }

            $query = "INSERT INTO db_profile (P_EMAIL, P_USERNAME, P_PASSWORD, P_NAME, P_LASTNAME, P_TELEPHONE) VALUES (?, ?, ?, ?, ?, ?)";
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

            $query = "INSERT INTO db_user (U_ID, U_GENDER) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$lastInsertId, $user->getGender()]);

            $user->setId($lastInsertId);

            return $user;
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }

    public function getUser($id)
    {
        try {
            $query = "SELECT * FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID WHERE p.P_ID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception("Error getting user: " . $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM db_profile p JOIN db_user u on p.P_ID=u.U_ID";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User($row['P_EMAIL'], $row['P_USERNAME'], $row['P_PASSWORD'], $row['P_NAME'], $row['P_LASTNAME'], $row['P_TELEPHONE'], $row['U_GENDER'], $row['P_ID']);
            }

            return $users;
        } catch (Exception $e) {
            throw new Exception("Error getting all users: " . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $query = "DELETE FROM db_profile WHERE P_ID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    public function updateUser($user)
    {
        try {
            $queryProfile = "UPDATE db_profile SET P_PASSWORD = ?, P_NAME = ?, P_LASTNAME = ?, P_TELEPHONE = ? WHERE P_ID = ?";
            $stmtProfile = $this->conn->prepare($queryProfile);
            $successProfile = $stmtProfile->execute([
                $user->getPassword(),
                $user->getName(),
                $user->getLastname(),
                $user->getTelephone(),
                $user->getId()
            ]);

            $queryUser = "UPDATE db_user SET U_GENDER = ? WHERE U_ID = ?";
            $stmtUser = $this->conn->prepare($queryUser);
            $successUser = $stmtUser->execute([
                $user->getGender(),
                $user->getId()
            ]);

            return $successProfile && $successUser;
        } catch (Exception $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }
}
