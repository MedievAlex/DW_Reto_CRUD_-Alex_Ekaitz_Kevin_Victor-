<?php
require_once '../Controller/Controller.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

$controller = new Controller();
$users = $controller->getAllUsers();

if ($users && count($users) > 0) {
    $userArray = [];

    foreach ($users as $user) {
        $userArray[] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'name' => $user->getName(),
            'lastname' => $user->getLastname(),
            'telephone' => $user->getTelephone(),
            'gender' => $user->getGender()
        ];
    }

    echo json_encode($userArray, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'Error fetching user'], JSON_UNESCAPED_UNICODE);
}
