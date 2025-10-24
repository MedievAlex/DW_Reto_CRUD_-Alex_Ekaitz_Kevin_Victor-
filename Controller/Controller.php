<?php
require_once '../config/Database.php';
require_once '../model/AdminModel.php';
require_once '../model/UserModel.php';


class Controller {
    private $adminModel;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->adminModel = new AdminModel($db);
        $this->userModel = new UserModel($db);
    }

    public function searchAllUsers() {
        return $this->adminModel->getAllUsers();
    }

    public function deleteUser() {
        return $this->adminModel->dropUser();
    }

    public function createUser() {
        return $this->adminModel->insertUser();
    }
}
?>