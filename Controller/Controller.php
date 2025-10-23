<?php
require_once '../config/Database.php';
require_once '../model/AdminModel.php';


class Controller {
    private $adminModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->adminModel = new AdminModel($db);
    }

    public function searchAllUsers() {
        return $this->adminModel->getAllUsers();
    }

    public function deleteUser() {
        return $this->adminModel->dropUser();
    }
}
?>