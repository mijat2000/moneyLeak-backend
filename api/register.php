<?php


//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); //GET,POST,DELETE

include_once('../config/config.php');
include_once('../models/User.php');
include_once('../config/mail.php');


//DB
$database = new Database();
$db = $database->connect();

//Getting data from body
$request_body = file_get_contents('php://input');
$data = (array) json_decode($request_body);


try {

    $email = $data['email'] ? htmlspecialchars(strip_tags($data['email'])) : '';
    $name = $data['name'] ? htmlspecialchars(strip_tags($data['name'])) : null;
    $lastname = $data['lastname'] ? htmlspecialchars(strip_tags($data['lastname'])) : null;
    $password = $data['password'] ? strip_tags($data['password']) : null;



    $model = new User($db);

    //Verify user data
    if ($model->checkEmail($email)->rowCount() > 0) {
        echo json_encode(array('message' => 'email already exist'));
        die();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('message' => 'email format is not valid'));
        die();
    }

    $hash = md5(rand());
    //Result
    $result = $model->register($email, $name, $lastname, $password, $hash);

    //Checking result
    $row_count = $result->rowCount();
    if ($row_count > 0) {
        $mail = new customMail();
        $mail->sendRegistrationEmail($email, $hash);
        echo json_encode(array('message' => 'success'));
    } else {
        //No data
        echo json_encode(array('message' => 'error'));
    }
} catch (Exception $e) {
    http_response_code(420);
    echo json_encode(array('message' => $e->getMessage()));
    die();
}
