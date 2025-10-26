<?php
require_once '../Controller/Controller.php';
require_once '../Model/User.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$controller = new Controller();

switch ($method) {
    case 'GET':
        $id = $_GET['id'] ?? null;

        try {
            $user = $controller->getUser($id);

            if ($user) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User retrieved successfully',
                    'user' => [
                        'id' => $user->getId(),
                        'email' => $user->getEmail(),
                        'username' => $user->getUsername(),
                        'password' => $user->getPassword(),
                        'name' => $user->getName(),
                        'lastname' => $user->getLastname(),
                        'telephone' => $user->getTelephone(),
                        'gender' => $user->getGender()
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error getting user: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'POST':
        try {
            $user = new User(
                $_POST['email'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                $_POST['name'] ?? '',
                $_POST['lastname'] ?? '',
                $_POST['telephone'] ?? '',
                $_POST['gender'] ?? 'MALE'
            );

            $result = $controller->createUser($user);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User created successfully',
                    'user' => [
                        'id' => $result->getId(),
                        'email' => $result->getEmail(),
                        'username' => $result->getUsername(),
                        'password' => $result->getPassword(),
                        'name' => $result->getName(),
                        'lastname' => $result->getLastname(),
                        'telephone' => $result->getTelephone(),
                        'gender' => $result->getGender()
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error creating user'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'PUT':
        // Implementar actualización de usuario
        echo json_encode(['message' => 'PUT method not implemented yet'], JSON_UNESCAPED_UNICODE);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;

        try {
            $result = $controller->deleteUser($id);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found or could not be deleted'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
        break;
}
