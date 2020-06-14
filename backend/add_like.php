<?php
session_start();
require_once('connection.php');
$id = $_SESSION['user']['ID'];
$ph_id = $_GET['Ph_ID'];


$query = 'select * from likes where User_ID = ? and Photo_ID = ?';
$stmt = $connection->prepare($query);
$res = $stmt->execute([$id,$ph_id]);

if($stmt->rowCount() > 0){
    $query = 'delete from likes where  photo_id = ? and user_id = ?';
    $stmt = $connection->prepare($query);
    $stmt->execute([$ph_id,$id]);
    header('Location:../feed.php');
} else {
    $query = 'insert into likes(photo_id, user_id) VALUES (?,?)';
    $stmt = $connection->prepare($query);
    $stmt->execute([$ph_id, $id]);
    header('Location:../feed.php');
}












