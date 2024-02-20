<?php

//Headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

include_once('../config/config.php');
include_once('../models/Post.php');


//DB
$database = new Database();
$db = $database->connect();

$post = new Post($db);

//GET Params
$id = isset($_GET['ImeParametra']) ? $_GET['ImeParametra'] : die();

$result = $post->read_single($id);
//...sVE JE OSTALO ISTO kao u getSomething
//http_response_code($code) -> ovo namesta na error