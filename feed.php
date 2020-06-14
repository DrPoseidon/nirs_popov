<?php
session_start();
if(!$_SESSION['user']){
    header('Location:/');
}
require_once('backend/connection.php');
$query = 'select * from users where login = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$_SESSION['user']['login']]);
$res = $stmt->fetch();
$ID = $res['User_ID'];
$email = $res['Email'];
$name = $res['Full_name'];
$login = $_SESSION['user']['login'];
$avatar = $res['Avatar'];

$query = 'select u.Login from followers as f left join users as u on f.Follower_ID = u.User_ID where f.User_ID = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$_SESSION['user']['ID']]);
$res = $stmt->fetchAll();
$subs = [];
foreach ($res as $r){
    $subs[] = $r['Login'];
}

$query = 'select * from photos left join users on photos.User_ID = users.User_ID order by Photo_upload_date desc';
$stmt = $connection->query($query);
$res = $stmt->fetchAll();
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

<a href="" class="show_all btn btn-info">Все пользователи</a>
<div class="under_all_div none">
    <div class="all_div">
        <div class="all_div_up" >
            <h2 style="font-size: 20px;margin: 0;">Все пользователи</h2>
            <input class="close_all_btn" type="image" src="img/delete.png" style="width: 20px;">
        </div>
        <div class="all_div_down">
            <?php
            $query1 = 'select Avatar,Login,User_ID from users order by Login';
            $stmt1 = $connection->query($query1);
            $res1 = $stmt1->fetchAll();
            foreach ($res1 as $all){
                if($all['Login'] !== $_SESSION['user']['login']){
                    echo '<div class="in_all_div_down"><p style="margin: 0;">'.$all['Login'].'</p>';
                    echo '<a href="another_profile.php?ID='.$all['User_ID'].'&Login='.$all['Login'].'"><img class="avatar_feed" src="'.str_replace(" ","",$all['Avatar']).'" ></a></div>';
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="header_div_feed" style="position: fixed">
    <a href="profile.php"><img class="avatar_feed" src="<?=$avatar?>"></a>
    <p class="p_profile" style="font-size: 1.5vh; margin: 0"><?=$login?></p>
</div>
<div class="feed_photos_div">
    <?php
    foreach ($res as $r){
        if(in_array($r['Login'],$subs)){
            echo '<div class="feed_photo_div"><div class="in_feed_photo_div">';
            if($r['User_ID'] == $_SESSION['user']['ID']){
                echo'<a href="profile.php"><img class="avatar_feed" src="'.$r['Avatar'].'"></a>';
            } else{
                echo'<a href="another_profile.php?ID='.$r['User_ID'].'&Login='.$r['Login'].'"><img class="avatar_feed" src="'.$r['Avatar'].'"></a>';
            } echo '<p style="margin: 0">'.$r['Login'].'</p></div>
<a href="this_photo.php?Photo_ID='.$r['Photo_ID'].'&User_ID='.$r['User_ID'].'"><img class = "feed_photos" src="'.$r['Path_to_photo'].'"></a><div class="down_div" style="height: 61px;border-top: 1px solid black;display: flex;flex-direction: row;align-items: center">';
            $q = 'select * from likes where User_ID = ? and Photo_ID = ?';
            $s = $connection->prepare($q);
            $s->execute([$_SESSION['user']['ID'],$r['Photo_ID']]);
            $q1 = 'select * from likes where Photo_ID = ?';
            $s1 = $connection->prepare($q1);
            $s1->execute([$r['Photo_ID']]);

            if($s->rowCount() > 0) {
                echo '<a href="backend/add_like.php?Ph_ID=' . $r['Photo_ID'] . '" class="like_a"><img src="img/like.png"  style="width: 30px;height: 30px;margin: 10px;"></a>'.$s1->rowCount();
            } else{
                echo '<a href="backend/add_like.php?Ph_ID=' . $r['Photo_ID'] . '" class="like_a"><img src="img/no-like.png"  style="width: 30px;height: 30px;margin: 10px;"></a>'.$s1->rowCount();
            }

            $com = 'select * from comments where Photo_ID = ?';
            $stmt_com = $connection->prepare($com);
            $stmt_com->execute([$r['Photo_ID']]);
            echo '<a href="this_photo.php?Photo_ID='.$r['Photo_ID'].'&User_ID='.$r['User_ID'].'"><img src="img/comment-black.png"  style="width: 30px;height: 30px;margin: 10px;"></a>'.$stmt_com->rowCount();
            echo '</div></div>';
        }
    }
    ?>
</div>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>