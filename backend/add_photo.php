<?php
session_start();
require_once('connection.php');
$type = $_FILES['photo']['type'];
$size =  $_FILES['photo']['size'];
$photo = 'uploads/' . time() . $_FILES['photo']['name'];

if (!move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo)) {
    $response = [
        "status" => false,
        "message" => "Ошибка при загрузке изображения",
    ];

    echo json_encode($response);

    die();
}

if($type === "image/jpeg" || $type === "image/JPG") {

    if ($size > 10 * pow(10, 6)) {
        $response = [
            "status" => false,
            "message" => "Слишком большой размер изображения",
        ];

        echo json_encode($response);

        die();
    }


    $query = 'insert into photos(user_id, path_to_photo, photo_upload_date) VALUES (?,?,?)';
    $stmt = $connection->prepare($query);
    $stmt->execute([$_SESSION['user']['ID'], $photo, date('Y-m-d H:i:s')]);
    $response = [
        "status" => true,
        "message" => "Фото добавлено",
    ];
    echo json_encode($response);
} else {
    $response = [
        "status" => false,
        "message" => "Расширение изображения не jpeg",
    ];

    echo json_encode($response);

    die();
}