<?php
require_once '../Controller/Controller.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    $controller = new Controller();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $users = $controller->getAllUsers();

        if ($users && count($users) > 0) {
            foreach ($users as $user) {
                $userArray[] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'username' => $user->getUsername(),
                    'password' => $user->getPassword(),
                    'name' => $user->getName(),
                    'lastname' => $user->getLastname(),
                    'telephone' => $user->getTelephone(),
                    'gender' => $user->getGender()
                ];
            }

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'All users retrieved correctly', 'users' => $userArray], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'No users found'], JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
