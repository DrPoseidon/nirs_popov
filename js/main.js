$('.show_reg').click(function (e) {
    e.preventDefault();
    $('.login_form').addClass('none');
    $('.register_form').removeClass('none');
});
$('.none_reg').click(function (e) {
    e.preventDefault();
    $('.register_form').addClass('none');
    $('.login_form').removeClass('none');
});
$('.gear_btn').click(function (e) {
    e.preventDefault();
    $('.in_body').removeClass('none');
});
$('.btn-back').click(function (e) {
    e.preventDefault();
    $('.msg2').addClass('none');
    $('.in_body').addClass('none');
});

$('.show_follow').click(function (e) {
    e.preventDefault();
    $('.under_follow_div').removeClass('none');
});

$('.close_follow_btn').click(function (e) {
    e.preventDefault();
    $('.under_follow_div').addClass('none');
});

$('.show_sub').click(function (e) {
    e.preventDefault();
    $('.under_sub_div').removeClass('none');
});

$('.close_sub_btn').click(function (e) {
    e.preventDefault();
    $('.under_sub_div').addClass('none');
});

$('.show_all').click(function (e) {
    e.preventDefault();
    $('.under_all_div').removeClass('none');
});

$('.close_all_btn').click(function (e) {
    e.preventDefault();
    $('.under_all_div').addClass('none');
});


/*
Авторизация
*/
$('.signin_btn').click(function (e) {
    e.preventDefault();
    $(`input`).removeClass('error');

    let login = $('input[name="signin_login"]').val(),
        pass = $('input[name="signin_pass"]').val();

    let formData = new FormData();
    formData.append('signin_login', login);
    formData.append('signin_pass',pass);

    $.ajax({
        url: 'backend/signin.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                document.location.href = '/profile.php';
            } else {
                if(data.type === 1){
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg1').addClass('msg-err').removeClass('none').text(data.message);
            }
        }
    });
});
/*
Регистрация
*/
$(function(){
    $('input[name="signup_phone"]').mask("+7 (999) 999-99-99");
});

let avatar = false;

$('input[name="avatar"]').change(function (e) {
    avatar = e.target.files[0];
});

$('.signup_btn').click(function (e) {
    e.preventDefault();
    $(`input`).removeClass('error');
    $('.msg2').addClass('none');

    let login = $('input[name="signup_login"]').val(),
        name = $('input[name="name"]').val(),
        email = $('input[name="email"]').val(),
        phone = $('input[name="signup_phone"]').val(),
        pass = $('input[name="signup_pass"]').val(),
        pass_confirm = $('input[name="signup_pass_confirm"]').val();

    let formData = new FormData();
    formData.append('signup_login', login);
    formData.append('name', name);
    formData.append('email', email);
    formData.append('signup_phone', phone);
    formData.append('signup_pass',pass);
    formData.append('signup_pass_confirm', pass_confirm);
    formData.append('avatar',avatar);

    $.ajax({
        url: 'backend/signup.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                document.location.href = '/profile.php';
            } else {
                if(data.type === 1){
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg2').addClass('msg-err').removeClass('none').text(data.message);
            }
        }
    });
});
/*
Добавление фото
 */
let photo = false;

$('input[name="photo"]').change(function (e) {
    photo = e.target.files[0];
});

$('.btn-add-photo').click(function (e) {
    e.preventDefault();
    $('.msg2').addClass('none');

    let formData = new FormData();

    formData.append('photo',photo);

    $.ajax({
        url: 'backend/add_photo.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                document.location.href = '/profile.php';
            } else {
                $('.msg2').addClass('msg-err').removeClass('none').text(data.message);
            }
        }
    });
});
/*
Подписка
 */
$('.btn-sub').click(function (e) {
    e.preventDefault();

    let login = $('input[name="Login"]').val(),
        id = $('input[name="ID"]').val();

    let formData = new FormData();
    formData.append('ID',id);

    $.ajax({
        url: 'backend/add_sub.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                document.location.href = '/another_profile.php?ID='+id+'&Login='+login;
                //document.location.href = document.referrer;
            }
        }
    });
});
/*
Отписка
 */
$('.btn-not_sub').click(function (e) {
    e.preventDefault();

    let login = $('input[name="Login"]').val(),
        id = $('input[name="ID"]').val();

    let formData = new FormData();
    formData.append('ID',id);

    $.ajax({
        url: 'backend/not_sub.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                document.location.href = '/another_profile.php?ID='+id+'&Login='+login;
                //document.location.href = document.referrer;
            }
        }
    });
});
/*
Добавление Комментария
 */
$('.comment-s').click(function (e) {
    e.preventDefault();

    let comment_text = $('textarea[name="comment_text"]').val(),
        user_id = $('input[name="user_ID"]').val(),
        ph_id = $('input[name="photo_ID1"]').val();

    let formData = new FormData();
    formData.append('comment_text',comment_text);
    formData.append('photo_ID1',ph_id);
    $.ajax({
        url: 'backend/add_comment.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                //document.location.href = '/this_photo.php?Photo_ID='+ph_id+'&User_ID='+user_id;
                //$(".down_div").load(location.href + " .down_div");
                $(".ccoments").load(location.href + " .comments");
                $(".comment_count").load(location.href + " .comment_count");
                $(".comment_form").load(location.href + " .comment_form");
            } else {
                if(data.type === 1){
                    data.fields.forEach(function (field) {
                        $(`textarea[name="${field}"]`).addClass('error');
                    });
                }
            }
        }
    });
});

/*
$('.add_like_btn1').click(function (e) {
    e.preventDefault();
    let searchParams = new URLSearchParams($('a[class="add_like1"]')[0].search.substring(1));
    let Ph_ID = searchParams.get('Ph_ID'),
        User_ID = searchParams.get('id1');
    $.get('backend/add_like1.php?PhID='+Ph_ID+'&id1='+User_ID);
});
*/
/*
Поставить лайк
 */

/*
like = $('input[name="n_o_l"]').val();
$('.like_btn').click(function (e) {
    e.preventDefault();

    let Ph_ID = $('input[name="p_id"]').val(),
        i = $('input[name="i"]').val(),
        User_ID = $('input[name="u_id"]').val();
    console.log(i,Ph_ID,User_ID);
    let formData = new FormData();
    formData.append('p_id',Ph_ID);
    formData.append('u_id',User_ID);
    formData.append('i',i);
    $.ajax({
        url: 'backend/add_like.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                $(".like_count").load(location.href + " .like_count");
                if(like == 0){
                    $(".like_img").attr("src","../img/like.png");
                    like = 1;
                } else{
                    $(".like_img").attr("src","../img/no-like.png");
                    like = 0;
                }
                //document.location.href = '/this_photo.php?Photo_ID='+Ph_ID+'&User_ID='+User_ID;

                //$(".down_div").load(location.href + " .down_div > *");
            }
        }
    });
});
*/

like = $('input[name="num_of_like"]').val();
$('.add_like_btn1').click(function (e) {
    e.preventDefault();

    let Ph_ID = $('input[name="Photo_ID"]').val(),
        User_ID = $('input[name="User_ID"]').val();

    let formData = new FormData();
    formData.append('Photo_ID',Ph_ID);
    formData.append('User_ID',User_ID);
    $.ajax({
        url: 'backend/add_like1.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if(data.status){
                $(".like_count").load(location.href + " .like_count");
                if(like == 0){
                    $(".like_img").attr("src","../img/like.png");
                    like = 1;
                } else{
                    $(".like_img").attr("src","../img/no-like.png");
                    like = 0;
                }
                //document.location.href = '/this_photo.php?Photo_ID='+Ph_ID+'&User_ID='+User_ID;

                //$(".down_div").load(location.href + " .down_div > *");
            }
        }
    });
});


