<?php


//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET'); //GET,POST,DELETE

include_once('../config/config.php');
include_once('../models/User.php');
include_once('../config/mail.php');




//DB
$database = new Database();
$db = $database->connect();

$model  = new User($db);
try {
    $email = $_GET['email'] ? htmlspecialchars(strip_tags($_GET['email'])) : null;


    //Result
    $return = $model->forgottenPassword($email);
    $result = $return->fetch(PDO::FETCH_ASSOC);
    $hash = $result['validation_key'];

    //Checking result
    $row_count = $return->rowCount();
    if ($row_count > 0) {
        $mail = new customMail();
        $mail->sendForgottenPassword($email, $hash);
        echo json_encode(array('message' => 'success'));
    } else {
        echo json_encode(array('message' => 'wrong credentials'));
    }
} catch (Exception $e) {
    http_response_code(420);
    echo json_encode(array('message' => $e->getMessage()));
    die();
}
