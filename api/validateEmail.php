<?php


//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET'); //GET,POST,DELETE

include_once('../config/config.php');
include_once('../models/User.php');



//DB
$database = new Database();
$db = $database->connect();





try {
    //Getting data from body
    $code = $_GET['code'] ? $_GET['code'] : '';

    $model = new User($db);



    $hash = md5(rand());
    //Result
    $result = $model->validateEmail($code);

    //Checking result
    $row_count = $result->rowCount();
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
