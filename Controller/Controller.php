<?php
require_once '../config/Database.php';
require_once '../model/AdminModel.php';


class Controller
{
    private $adminModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->adminModel = new AdminModel($db);
    }

    public function getAllUsers()
    {
        return $this->adminModel->getAllUsers();
    }

    public function createUsers()
    {
        return $this->adminModel->createUser();
    }

    public function deleteUser()
    {
        return $this->adminModel->deleteUser();
    }
}
