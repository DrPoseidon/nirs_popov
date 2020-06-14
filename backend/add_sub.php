<?php
session_start();
require_once('connection.php');
$id = $_POST['ID'];
$_SESSION['user']['ID'];
$query = 'INSERT INTO `followers`(`Follower_ID`, `User_ID`) VALUES (?,?)';
$stmt = $connection->prepare($query);
$stmt->execute([$id, $_SESSION['user']['ID']]);

$response = [
    "status" => true,
    "message" => "Подписано успешно",
];

echo json_encode($response);