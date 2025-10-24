<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../controller/Controller.php';
$database = new Database();
$db = $database->getConnection();
$userController = new UserController($db);
$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->username) &&
    !empty($data->email) &&
    !empty($data->password) &&
    !empty($data->name) &&
    !empty($data->lastname) &&
    !empty($data->telephone) &&
    !empty($data->gender) &&
    !empty($data->card_number)
) {
    $userController->username = $data->username;
    $userController->email = $data->email;
    $userController->password = password_hash($data->password, PASSWORD_BCRYPT);
    $userController->name = $data->name;
    $userController->lastname = $data->lastname;
    $userController->telephone = $data->telephone;
    $userController->gender = $data->gender;
    $userController->card_number = $data->card_number;

    if ($userController->usernameExists()) {
        http_response_code(400);
        echo json_encode(array("message" => "Username already exists. Please choose a different username."));
    } else if ($userController->createUser()) {
        http_response_code(201);
        echo json_encode(array("message" => "User created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data. Please provide username, email, and password."));
}
?>