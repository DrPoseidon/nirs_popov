<?php
session_start();
if(!$_SESSION['user']){
    header('Location:/');
}
require_once('backend/connection.php');

$User_ID = $_GET['User_ID'];
$Photo_ID = $_GET['Photo_ID'];

$query = 'select * from photos as p left join users as u on p.User_ID = u.User_ID where p.User_ID = ? and p.Photo_ID = ?';
$stmt = $connection->prepare($query);
$stmt->execute([$User_ID,$Photo_ID]);
$r = $stmt->fetch();
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
<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="btn btn-info">Назад</a>
<div class="header_div_feed" style="position: fixed">
    <a href="profile.php"><img class="avatar_feed" src="<?=$_SESSION['user']['avatar']?>"></a>
    <p class="p_profile" style="font-size: 1.5vh; margin: 0"><?=$_SESSION['user']['login']?></p>
</div>
<div class="feed_photos_div">
    <?php
    echo '<div class="feed_photo_div"><div class="in_feed_photo_div">';
    if($User_ID == $_SESSION['user']['ID']){
        echo'<a href="profile.php"><img class="avatar_feed" src="'.$r['Avatar'].'"></a>';
    } else{
        echo'<a href="another_profile.php?ID='.$r['User_ID'].'&Login='.$r['Login'].'"><img class="avatar_feed" src="'.$r['Avatar'].'"></a>';
    } echo '<p style="margin: 0">'.$r['Login'].'</p></div>
<img class = "feed_photos" src="'.$r['Path_to_photo'].'"><div class="down_div" style="height: 61px;border-top: 1px solid black;display: flex;flex-direction: row;align-items: center">';
    $q = 'select * from likes where User_ID = ? and Photo_ID = ?';
    $s = $connection->prepare($q);
    $s->execute([$_SESSION['user']['ID'],$r['Photo_ID']]);
    $q1 = 'select * from likes where Photo_ID = ?';
    $s1 = $connection->prepare($q1);
    $s1->execute([$r['Photo_ID']]);
    $com = 'select * from comments where Photo_ID = ?';
    $stmt_com = $connection->prepare($com);
    $stmt_com->execute([$r['Photo_ID']]);
    echo'<form style="display: flex;flex-direction: row;align-items: center" class="add_like1">
<input type="text" name="Photo_ID" value="'.$r['Photo_ID'].'" style="display: none">
<input type="text" name="User_ID" value="'.$r['User_ID'].'" style="display: none">
<input type="text" name="num_of_like" value="'.$s->rowCount().'" style="display: none">
</form>
<button type="submit" class="add_like_btn1" style="background-color: initial;outline: none;border: none;">';
    if($s->rowCount() > 0){
        echo '<input class="like_img" type="image" src="img/like.png" style="width: 30px;height: 30px;margin: 10px;">';
    } else{
        echo '<input class="like_img" type="image" src="img/no-like.png" style="width: 30px;height: 30px;margin: 10px;">';
    }
    echo '</button><div class="like_count">'.$s1->rowCount().'</div>';
    echo '<img src="img/comment-black.png"  style="width: 30px;height: 30px;margin: 10px;"><div class="comment_count">'.$stmt_com->rowCount().'</div>';

    echo '</div></div>';

    ?>
    <div class="comment_div" style="width: 600px; height: 100px">
        <form class="comment_form">
            <textarea name="comment_text" style="width: 100%;height: 100%;resize: none;padding: 10px;font-size: 20px;"></textarea></form>
        <input type="text" name="photo_ID1" value="<?=$Photo_ID?>" style="display: none">
        <input type="text" name="user_ID" value="<?=$User_ID?>" style="display: none">
        <button type="submit" class="comment-s" style="background: initial;border: none;position: relative;top: -50px;left: 92%;">
            <input type="image" src="img/comment-s.png" style="width: 30px;height: 30px">
        </button>
        <?php
        $a = 'select * from comments as c left join users as u on c.User_ID=u.User_ID where Photo_ID = ? order by Comment_added_date desc';
        $b = $connection->prepare($a);
        $b->execute([$Photo_ID]);
        $res_b = $b->fetchAll();
            echo '<div class="ccoments" style="overflow: scroll;overflow-x: hidden;height: 200px;">';
            foreach ($res_b as $rb) {
                echo '<div class="comments" style="display: flex;flex-direction: row;align-items: center;justify-content: space-between">
        <div class="in_comment_div" style="display: flex;flex-direction: column;align-items: center;width: 20%;">';
                if ($_SESSION['user']['login'] == $rb['Login']) {
                    echo '<a href="profile.php"><img src="' . $rb['Avatar'] . '" class="avatar_feed" ></a>' . $rb['Login'] . '</div>';
                } else {
                    echo '<a href="another_profile.php?ID=' . $rb['User_ID'] . '&Login=' . $rb['Login'] . '"><img src="' . $rb['Avatar'] . '" class="avatar_feed" ></a>' . $rb['Login'] . '</div>';
                }

                echo '<textarea name="comment_text" style="width: 75%;height: auto%;resize: none;padding: 10px;font-size: 20px;outline: none;margin-bottom: 10px;border: none!important;" readonly>' . $rb['Comment_text'] . '</textarea>
    </div>';
            }
            echo '</div>';
        ?>
    </div>
</div>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>