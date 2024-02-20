<?php


//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); //GET,POST,DELETE

include_once('../config/config.php');
include_once('../models/User.php');



//DB
$database = new Database();
$db = $database->connect();

//Getting data from body
$request_body = file_get_contents('php://input');
$data = (array) json_decode($request_body);

$model  = new User($db);
try {
    $email = $data['email'] ? htmlspecialchars(strip_tags($data['email'])) : null;
    $password = $data['password'] ? strip_tags($data['password']) : null;

    //Result
    $return = $model->login($email, $password);
    $result = $return->fetch(PDO::FETCH_ASSOC);

    //Checking result
    $row_count = $return->rowCount();
    if ($row_count > 0) {

        echo json_encode(array('message' => $result['is_verified'] ? 'success' : 'not verified', 'id' => $result['id_user']));
    } else {
        echo json_encode(array('message' => 'wrong credentials'));
    }
} catch (Exception $e) {
    http_response_code(420);
    echo json_encode(array('message' => $e->getMessage()));
    die();
}
