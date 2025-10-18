<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once '../Controller/UserController.php';

$controller = new UserController();
$users = $controller->searchAllUsers();

if ($users && count($users) > 0) {
    $userArray = [];

    foreach ($users as $user) {
        $userArray[] = [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'name' => $user->getName(),
            'lastname' => $user->getLastname(),
            'telephone' => $user->getTelephone(),
            'gender' => $user->getGender(),
            'card_number' => $user->getCardNumber()
        ];
    }

    echo json_encode($userArray, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'Error fetching user'], JSON_UNESCAPED_UNICODE);
}
?>
