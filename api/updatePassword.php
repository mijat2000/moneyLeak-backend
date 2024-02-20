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


try {
    $code = $data['code'] ? htmlspecialchars(strip_tags($data['code'])) : null;
    $newPassword = $data['newPassword'] ? htmlspecialchars(strip_tags($data['newPassword'])) : null;

    $model  = new User($db);

    //Result
    $return = $model->updatePassword($code, $newPassword);
    $result = $return->fetch(PDO::FETCH_ASSOC);

    //Checking result
    $row_count = $return->rowCount();
    if ($row_count > 0) {
        echo json_encode(array('message' => 'success'));
    } else {
        echo json_encode(array('message' => 'error'));
    }
} catch (Exception $e) {
    http_response_code(420);
    echo json_encode(array('message' => $e->getMessage()));
    die();
}
