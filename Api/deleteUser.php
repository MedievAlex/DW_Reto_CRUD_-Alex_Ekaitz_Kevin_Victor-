<?php //Aun sin empezar es solo una copia del searchAllUsers.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once '../Controller/Controller.php';

var_dump($_GET); // Verifica si $_GET contiene datos
$id = $_POST['id'] ?? '';
var_dump($id);
if ($id) {
    $controller = new Controller();
    $success = $controller->deleteUser($id);

    if ($success) {
        echo json_encode([
            "success" => true,
            "message" => "User deleted successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error deleting user."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se proporcionó ID."
    ]);
}
?>