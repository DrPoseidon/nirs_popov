<?php
session_start();
require_once('connection.php');
$comment_text = $_POST['comment_text'];
$photo_id = $_POST['photo_ID1'];
$error_fields = [];

if($comment_text === ''){
    $error_fields[] = 'comment_text';
}

if(!empty($error_fields)){
    $response = [
        "status" => false,
        "type" => 1,
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}

$query = 'insert into comments(comment_id, user_id, photo_id, comment_text, comment_added_date) values (?,?,?,?,?)';
$stmt = $connection->prepare($query);
$stmt->execute([rand(0,1000000),$_SESSION['user']['ID'],$photo_id,$comment_text,date('Y-m-d H:i:s')]);
$response = [
    "status" => true,
    "message" => "Комментарий добавлен",
];

echo json_encode($response);




