<?php
session_start();
require_once('connection.php');
$login = $_POST['signup_login'];/////////////////Не должны совпадать
$name = $_POST['name'];
$email = $_POST['email'];/////////////////Не должны совпадать
$email = mb_strtolower($email);
$phone = $_POST['signup_phone'];/////////////////Не должны совпадать
$pass = $_POST['signup_pass'];
$pass_confirm = $_POST['signup_pass_confirm'];
$type = $_FILES['avatar']['type'];
$size =  $_FILES['avatar']['size'];
$error_fields = [];

if($login === ''){
    $error_fields[] = 'signup_login';
}

if($name === ''){
    $error_fields[] = 'name';
}

if($email=== '' || !filter_var($email,FILTER_VALIDATE_EMAIL)){
    $error_fields[] = 'email';
}

if($pass === ''){
    $error_fields[] = 'signup_pass';
}

if($pass_confirm === ''){
    $error_fields[] = 'signup_pass_confirm';
}

if($_FILES['avatar']) {
    if($type != 'image/jpeg' && $type != 'image/jpg'){
        $response = [
            "status" => false,
            "message" => "Расширение изображения не jpeg"
        ];

        echo json_encode($response);

        die();
    }

    if($size > 10 * pow(10,6)){
        $response = [
            "status" => false,
            "message" => "Слишком большой размер изображения",
        ];

        echo json_encode($response);

        die();
    }
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

if($pass == $pass_confirm){
    if($_FILES['avatar']) {
        $avatar = 'uploads/' . time() . $_FILES['avatar']['name'];
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $avatar)) {
            $response = [
                "status" => false,
                "message" => "Ошибка при загрузке изображения",
            ];

            echo json_encode($response);
        }
    } else{
        $avatar = 'img/noavatar.png';
    }
    $query = 'select * from users where login = ?';
    $stmt = $connection->prepare($query);
    $stmt->execute([$login]);
    $res = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $response = [
            "status" => false,
            "message" => "Такой логин уже существует",
        ];

        echo json_encode($response);

        die();
    }
    $query = 'select * from users where email = ?';
    $stmt = $connection->prepare($query);
    $stmt->execute([$email]);
    $res = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $response = [
            "status" => false,
            "message" => "Такой email уже существует",
        ];

        echo json_encode($response);

        die();
    }
    $query = 'select * from users where phone_number =?';
    $stmt = $connection->prepare($query);
    $stmt->execute([$phone]);
    $res = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $response = [
            "status" => false,
            "message" => "Такой номер телефона уже существует",
        ];

        echo json_encode($response);

        die();
    }
        $query = 'insert into users(login, password, avatar, email, phone_number, full_name) values (?,?,?,?,?,?)';
        $stmt = $connection->prepare($query);
        $stmt->execute([$login,md5($pass),$avatar,$email,$phone,$name]);
        $_SESSION['user']['login'] = $login;
        $_SESSION['user']['ID'] = $connection->lastInsertId();
        $_SESSION['user']['avatar'] = $avatar;
        $response = [
            "status" => true,
            "message" => "Регистрация прошла успешно",
        ];
    echo json_encode($response);
} else{
    $response = [
        "status" => false,
        "message" => "Пароли не совпадают",
    ];

    echo json_encode($response);

    die();
}