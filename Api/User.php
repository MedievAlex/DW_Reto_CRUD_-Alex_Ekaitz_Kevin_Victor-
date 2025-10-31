<?php
require_once '../Controller/Controller.php';
require_once '../Model/User.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$controller = new Controller();

switch ($method) {
    case 'GET':
        $id = $_GET['id'] ?? null;

        try {
            $user = $controller->getUser($id);

            if ($user) {
                http_response_code(200);
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
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'User not found'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            http_response_code(500);
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
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'User created successfully',
                    'user' => [
                        'id' => $result->getId(),
                        'username' => $result->getUsername(),
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Error creating user'], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error creating user: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'PUT':
        $id = $_GET['id'] ?? null;

        try {
            parse_str(file_get_contents('php://input'), $data); // Recoger datos de la solicitud PUT

            $user = new User(
                $data['email'] ?? '',
                $data['username'] ?? '',
                $data['password'] ?? '',
                $data['name'] ?? '',
                $data['lastname'] ?? '',
                $data['telephone'] ?? '',
                $data['gender'] ?? 'MALE',
                $id
            );

            $result = $controller->updateUser($user);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'User updated successfully',
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error updating user'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;

        try {
            $result = $controller->deleteUser($id);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found or could not be deleted'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
        break;
}
