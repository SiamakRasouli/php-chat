<?php

include 'loader.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $where['message_from'] = $_POST['send_from'];
    $where['message_to'] = $_POST['send_to'];

    $query = "SELECT * FROM messages WHERE(message_from = :message_from AND message_to = :message_to) OR (message_from = :message_to AND message_to = :message_from)";

    $params = [
        'message_from' => $where['message_from'],
        'message_to' => $where['message_to'],
        'message_to' => $where['message_from'],
        'message_from' => $where['message_to'],
    ];

    $data = $db->query($query, $params);
    $data = $data->fetchAll();

    $query = "UPDATE messages SET status = 2 WHERE(message_to = :message_from AND message_from = :message_to)";
    $params = [
        'message_from' => $where['message_from'],
        'message_to' => $where['message_to']
    ];

    $db->query($query, $params);

    //lets work on message response
    $messages = '';
    foreach($data as $key => $value) {
        if($value['message_from'] == $where['message_from']) {
            $status = ($value['status'] == 1) ?: 'check_readed';
            $messages .= "<div class='message_to'>
                        <p>{$value['message']}
                        <span class='check {$status}'>&check;&check;</span></p>
                        <span>{$value['send_date']}</span>
                        </div>";
        } else {
            $messages .= "<div class='message_from'>
                            <p>{$value['message']}</p>
                            <span>{$value['send_date']}</span>
                        </div>";
        }
    }
    echo $messages; 
}