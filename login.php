
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
<form class="login_form">
    <input type="text" name="signin_login" placeholder="Логин или Почта" class="form-control login_input" style="width: 250px;">
    <input type="password" name="signin_pass" placeholder="Пароль" class="form-control pass_input" style="width: 250px;">
    <button type="submit" class="btn btn-success signin_btn" style="width: 200px;">Войти</button>
    <a href="" class="show_reg">Зарегистрироваться</a>
    <p class="msg1 none">Lorem ipsum dolor sit amet.</p>
</form>

<form class="register_form none">
    <input type="text" name="signup_login" placeholder="Логин" class="form-control register_input" style="width: 250px;">
    <input type="text" name="name" placeholder="Имя" class="form-control register_input" style="width: 250px;">
    <input type="email" name="email" placeholder="Email" class="form-control register_input" style="width: 250px;">
    <input type="tel" name="signup_phone" placeholder="Номер телефона" class="form-control register_input" style="width: 250px;">
    <input type="password" name="signup_pass" placeholder="Пароль" class="form-control register_input" style="width: 250px;">
    <input type="password" name="signup_pass_confirm" placeholder="Подтверждение пароля" class="form-control register_input" style="width: 250px;">
    <div class="custom-file register_input" style="width: 250px;">
        <input type="file" name="avatar" class="custom-file-input " id="customFile">
        <label class="custom-file-label" for="customFile">Выберите файл</label>
    </div>
    <button type="submit" class="btn btn-success signup_btn" style="width: 200px;">Зарегистрироваться</button>
    <a href="" class="none_reg">Войти</a>
    <p class="msg2 none">Lorem ipsum dolor sit amet.</p>
</form>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>