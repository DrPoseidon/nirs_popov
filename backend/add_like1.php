<?php
session_start();
require_once('connection.php');
$id = $_SESSION['user']['ID'].'</br>';
$ph_id = $_POST['Photo_ID'].'</br>';

$query = 'select * from likes where User_ID = ? and Photo_ID = ?';
$stmt = $connection->prepare($query);
$res = $stmt->execute([$id,$ph_id]);

if($stmt->rowCount() > 0){
    $query = 'delete from likes where  photo_id = ? and user_id = ?';
    $stmt = $connection->prepare($query);
    $stmt->execute([$ph_id,$id]);
    $response = [
        "status" => true,
        "message" => "Лайк убран",
    ];

    echo json_encode($response);
} else {
    $query = 'insert into likes(photo_id, user_id) VALUES (?,?)';
    $stmt = $connection->prepare($query);
    $stmt->execute([$ph_id,$id]);
    $response = [
        "status" => true,
        "message" => "Лайк добавлен",
    ];

    echo json_encode($response);
}





