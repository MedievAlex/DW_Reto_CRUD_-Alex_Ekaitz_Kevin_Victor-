<?php
require_once '../Controller/Controller.php';
require_once '../Model/User.php';
require_once '../Model/Admin.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
  $controller = new Controller();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $credential = $_POST['credential'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $controller->login($credential, $password);

    if ($result) {
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'profile' => [
          'type' => $result instanceof User ? 'user' : 'admin',
          'id' => $result->getId(),
          'username' => $result->getUsername()
        ]
      ], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(401);
      echo json_encode(['success' => false, 'message' => 'Invalid credentials'], JSON_UNESCAPED_UNICODE);
    }
  } else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
  }
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
