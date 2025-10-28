<?php
require_once '../config/Database.php';
require_once '../model/DBImplementation.php';


class Controller
{
    private $dBImplementation;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->dBImplementation = new DBImplementation($db);
    }

    public function login($credential, $password)
    {
        return $this->dBImplementation->login($credential, $password);
    }

    public function getUser($id)
    {
        return $this->dBImplementation->getUser($id);
    }

    public function getAllUsers()
    {
        return $this->dBImplementation->getAllUsers();
    }

    public function createUser($user)
    {
        return $this->dBImplementation->createUser($user);
    }

    public function deleteUser($id)
    {
        return $this->dBImplementation->deleteUser($id);
    }

    public function updateUser($user)
    {
        return $this->dBImplementation->updateUser($user);
    }
}
