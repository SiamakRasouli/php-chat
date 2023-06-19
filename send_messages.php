<?php

include 'loader.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = json_decode(file_get_contents('php://input'), true);
    $db->insert('messages', $data);
    echo json_encode('message: sended!');
}