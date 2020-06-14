<?php
session_start();
require_once('connection.php');
$login = $_POST['signin_login'];
$pass = $_POST['signin_pass'];
$error_fields = [];

if($login === ''){
    $error_fields[] = 'signin_login';
}

if($pass === ''){
    $error_fields[] = 'signin_pass';
}
if(!empty($error_fields)){
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте правильность полей",
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}
if(filter_var($login,FILTER_VALIDATE_EMAIL)){
    mb_strtolower($login);
}

$query = 'select * from users where Email = ? or Login = ? and Password = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$login,$login,md5($pass)]);
$res = $stmt->fetch();
if($stmt->rowCount() > 0){
    $_SESSION['user']['login'] = $res['Login'];
    $_SESSION['user']['ID'] = $res['User_ID'];
    $_SESSION['user']['avatar'] = $res['Avatar'];
    $response = [
        "status" => true
    ];
    echo json_encode($response);
} else {
    $response = [
        "status" => false,
        "message" => "Неправильные данные",
    ];

    echo json_encode($response);

    die();
}