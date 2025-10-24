<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once '../Controller/Controller.php';

$controller = new Controller();
$users = $controller->searchAllUsers();

if ($users === false) {
    // Caso: Error al obtener los usuarios
    echo json_encode(['error' => 'Error fetching users from the database'], JSON_UNESCAPED_UNICODE);
} elseif (is_array($users) && count($users) === 0) {
    // Caso: No hay usuarios disponibles
    $arrayVacio[] = '';
    echo json_encode([$arrayVacio, 'message' => 'No users available'], JSON_UNESCAPED_UNICODE);
} else {
    // Caso: Usuarios obtenidos correctamente
    $userArray = [];

    foreach ($users as $user) {
        $userArray[] = [
            'id' => $user->getId(),
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
}
?>
