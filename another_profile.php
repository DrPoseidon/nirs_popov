<?php
session_start();
if(!$_SESSION['user']){
    header('Location:/');
}
require_once('backend/connection.php');
$login = $_GET['Login'];
$ID = $_GET['ID'];
$query = 'select * from users where login = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$login]);
$res = $stmt->fetch();
$email = $res['Email'];
$name = $res['Full_name'];
$avatar = $res['Avatar'];
$query = 'select * from photos where User_ID= ?';
$stmt = $connection->prepare($query);
$stmt->execute([$ID]);
$res = $stmt->fetchAll();
$number_of_publications = $stmt->rowCount();
$query = 'select * from followers where User_ID= ?';
$stmt = $connection->prepare($query);
$stmt->execute([$ID]);
$res = $stmt->fetchAll();
$number_of_subscriptions = $stmt->rowCount();
$query = 'select * from followers where Follower_ID= ?';
$stmt = $connection->prepare($query);
$stmt->execute([$ID]);
$res = $stmt->fetchAll();
 $number_of_followers= $stmt->rowCount();

$qr= 'select * from photos where User_ID = ? order by Photo_upload_date desc';
$st = $connection->prepare($qr);
$st->execute([$ID]);
$photo_array = $st->fetchAll();

$qr1 = 'select * from followers where User_ID = ? and Follower_ID = ?';
$stmt1 = $connection->prepare($qr1);
$stmt1->execute([$_SESSION['user']['ID'],$ID]);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="header_div_feed" style="position: fixed">
    <a href="profile.php"><img class="avatar_feed" src="<?=$_SESSION['user']['avatar']?>"></a>
    <p class="p_profile" style="font-size: 1.5vh; margin: 0"><?=$_SESSION['user']['login']?></p>
</div>
<a href="feed.php" class="btn btn-info">На главную</a>
<div class="header_div">
    <img class="avatar" src="<?=$avatar?>">
    <div class="in_header_div">
        <div class="in_header_div1">
            <p class="p_profile"><?=$login?></p>
        </div>
        <div class="in_header_div3" >
            <p style="margin-right: 5px;"><?=$number_of_publications?></p><p style="margin-right: 10px;font-weight: 200;">публикаций</p>
            <p style="margin-right: 5px;"><?=$number_of_followers?></p><p style="margin-right: 10px;font-weight: 200;">подписчиков</p>
            <p style="margin-right: 5px;"><?=$number_of_subscriptions?></p><p style="margin-right: 10px;font-weight: 200;">подписок</p>
        </div>
        <div class="in_header_div2">
            <p class="p_profile"><?=$name?></p>
            <form>
                <input type="text" value="<?=$ID?>" style="display: none" name="ID">
                <input type="text" value="<?=$login?>" style="display: none" name="Login">
                <?php
                if($stmt1->rowCount() > 0){
                    echo '<button class="btn btn-danger btn-not_sub">Отписаться</button>';
                } else{
                    echo '<button class="btn btn-success btn-sub">Подписаться</button>';
                }
                ?>
            </form>
        </div>
    </div>
</div>
<div class="in_body none" style="position: absolute;width: 100vw;height: 100vh;background-color: rgba(94,94,94,0.7);top: 0;left: 0;z-index: 1">
    <div class="popup_div">
        <a href="backend/logout.php" style="width: 100%"><button class="btn btn-danger" style="width: 100%;border: 1px solid gray;border-radius: 10px 10px 0 0;">Выход</button></a>
        <button class="btn btn-black btn-back" style="background: initial; border: 1px solid gray;color: black;width: 100%;border-radius: 0;background-color: white">Назад</button>
        <button class="btn btn-black" style="background: initial; border: 1px solid gray;color: black;width: 100%;border-radius: 0;background-color: white">Редактировать профиль</button>
        <form style="width: 100%;border: 1px solid gray;border-radius: 0 0 11px 11px">
            <div class="input-group mb-3" style="width: 100%;">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary btn-add-photo" type="button" style="border-radius: 0 0 0 10px;background-color: white">Загрузить</button>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="photo" id="customFileLang" lang="ru" >
                    <label class="custom-file-label" for="customFileLang" style="border-radius: 0 0 10px 0!important;">Выберите файл</label>
                </div>
            </div>
        </form>
        <p class="msg2 none" style="background-color: red;color: white;border-radius: 5px;padding: 5px;margin-top: 5px;position: absolute;top:125%;transform: translate(0,-100%);">Lorem ipsum dolor sit amet.</p>
    </div>
</div>
<style>
    .mb-3,.my-3{
        margin-bottom: 0!important;
    }
    .custom-file-label::after{
        border-radius: 0 0 10px 0!important;
    }
</style>
<div class="photos_div">
    <?php
    $qr1 = 'select * from likes where Photo_ID = ?';
    $qr2 = 'select * from comments where Photo_ID = ?';
    foreach ($photo_array as $pa){
        echo '<a href="this_photo.php?Photo_ID='.$pa['Photo_ID'].'&User_ID='.$pa['User_ID'].'"><div class="pr_ph">';
        $stmt2 = $connection->prepare($qr1);
        $stmt2->execute([$pa['Photo_ID']]);
        $stmt3 = $connection->prepare($qr2);
        $stmt3->execute([$pa['Photo_ID']]);
        echo '<div class="hover_div">
<div class="in_hover_div" style="width: 30%">
<div class="in_hover_div1">
<img src="img/white-like.png" style="width: 30px;height: 30px;"><p style="color: white;margin: 0">'.$stmt2->rowCount().'</p>
</div>
<div class="in_hover_div1">
<img src="img/comment.png" style="width: 30px;height: 30px"><p style="color: white;margin: 0">'.$stmt3->rowCount().'</p>
</div>
</div>
</div><img class ="profile_photos" src="'.$pa['Path_to_photo'].'">
</div></a>';
    }
    ?>
</div>



<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>