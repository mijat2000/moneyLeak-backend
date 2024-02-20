<?php

//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); //GET,POST,DELETE

include_once('../config/config.php');
include_once('../models/Post.php');


//DB
$database = new Database();
$db = $database->connect();

$post = new Post($db);

//RESULT
$result = $post->read();

//ROW COUNT
$row_count = $result->rowCount();
if ($num > 0) {
    //reult array
    $result_array = array();
    $result_array['data'] = array();

    //taking Data
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $data_row = array(
            'id' => $id,
            //I TAKO DALJE
        );

        //Push to array
        array_push($result_array['data'], $data_row);

        //Convert to JSON
        echo json_encode($result_array);
    }
} else {
    //No data
    echo json_encode(array('message' => 'No data'));
}
