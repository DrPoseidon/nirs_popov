<?php
session_start();
require_once('connection.php');
$id = $_POST['ID'];
$query = 'delete from followers where User_ID = ? and Follower_ID = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$_SESSION['user']['ID'],$id]);

$response = [
    "status" => true,
    "message" => "Отписано успешно",
];
echo json_encode($response);