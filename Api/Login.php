<?php
require_once '../Controller/Controller.php';
require_once '../Model/User.php';
require_once '../Model/Admin.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$controller = new Controller();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $credential = $_POST['credential'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $controller->login($credential, $password);

    if ($result) {
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
      echo json_encode(['success' => false, 'message' => 'Invalid credentials'], JSON_UNESCAPED_UNICODE);
    }
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
