<?php
    require 'db_connect.php';
?>
<?php

$sql="select * from user_type";
$user_types = mysqli_query($link, $sql) or die("database error:" . mysqli_error($link));

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 pt-3 pb-3 text-center" style="background-color: #1c1f23; color:white;"><div class="title">РЕГИСТРАЦИЯ</div></div>
        </div>
        <div class="row mt-5">
            <div class="col-3">
                <div class="title">КТО ВЫ?</div>
                <div>В зависимости от выбранного типа аккаунта у вас будет возможность содержать несколько вакансий или одно резюме. </div>

                    <?php
                        foreach ($user_types as $user_type){
                            $id=$user_type['id'];
                            $title=$user_type['title'];
                            ?>
                            <input type="radio"
                                   name="user_type" value="<?=$id?>">
                            <label for="contactChoice1"><?=$title?></label>
                        <?php
                        }
                    ?>
            </div>
            <div class="col-1" style="border-right:1px solid black"></div>
            <div class="col-1"></div>
            <div class="col-7">
                <div id="user_type_title" class="title"></div>
                <div class="form-input-block">
                    <div class="input-label" id="name_label"></div>
                    <input class="form-input" id="user_name">
                    <div class="form-error" id="name_error"></div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="form-input-block">
                            <div class="input-label" >ЛОГИН ДЛЯ ВХОДА В АККАУНТ</div>
                            <input class="form-input" id="user_login">
                            <div class="form-error" id="login_error"></div>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <div class="form-input-block">
                            <div class="input-label">ПАРОЛЬ ДЛЯ ВХОДА В АККАУНТ</div>
                            <input class="form-input" id="user_password">
                            <div class="form-error" id="password_error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="form-input-block">
                            <div class="input-label" id="phone_label"></div>
                            <input class="form-input" id="user_phone">
                            <div class="form-error" id="phone_error"></div>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <div class="form-input-block">
                            <div class="input-label" id="email_label"></div>
                            <input class="form-input" id="user_email">
                            <div class="form-error" id="email_error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5"><button class="form-button mt-5" onclick="trySignUp()">ЗАРЕГИСТРИРОВАТЬСЯ</button></div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            var $radios = $('input:radio[name=user_type]');
            if($radios.is(':checked') === false) {
                $radios.filter('[value=1]').prop('checked', true);
            }
            $("#user_type_title").text('РАБОТНИК');
            $("#name_label").text('Ваше ФИО');
            $("#phone_label").text('ВАШ ТЕЛЕФОН В ФОРМАТЕ XXX XX XXX XX XX');
            $("#email_label").text('ВАША ПОЧТА');


        });

        $('input[type=radio][name=user_type]').change(function() {
            //alert('chaned');
            //alert(this.value);
            if (this.value == 1) {
                $("#user_type_title").text('РАБОТНИК');
                $("#name_label").text('Ваше ФИО');
                $("#phone_label").text('ВАШ ТЕЛЕФОН В ФОРМАТЕ XXX XX XXX XX XX');
                $("#email_label").text('ВАША ПОЧТА');
            }else if (this.value == 2) {
                $("#user_type_title").text('РАБОТОДАТЕЛЬ');
                $("#name_label").text('имя вашей компании');
                $("#phone_label").text('ТЕЛЕФОН ВАШЕЙ КОМПАНИИ В ФОРМАТЕ XXX XX XXX XX XX');
                $("#email_label").text('ЭЛЕКТРОННАЯ ПОЧТА ВАШЕЙ КОМПАНИИ');
            }
        });

        function trySignUp(){
            user_type_id=$( "input[type=radio][name=user_type]:checked" ).val();
            user_name=$('#user_name').val();
            user_login=$('#user_login').val();
            user_password=$('#user_password').val();
            user_email=$('#user_email').val();
            user_phone=$('#user_phone').val();

            $.ajax({
                type:"POST",
                url: "functions/validate_sign_up.php",
                data:{user_type_id:user_type_id, user_name:user_name, user_login:user_login, user_password:user_password, user_email: user_email, user_phone:user_phone},
                success:function (response){
                    response=JSON.parse(response);
                    if(response.state=='success'){
                        //alert('Успех валидации');

                        $.ajax({
                            type:"POST",
                            url: "functions/sign_up.php",
                            data:{user_type_id:user_type_id, user_name:user_name, user_login:user_login, user_password:user_password, user_email: user_email, user_phone:user_phone},
                            success:function (response_2){
                                console.log(response_2);
                                //alert('ответ 2...');
                                response_2=JSON.parse(response_2);
                                console.log(response_2);
                                //alert('ответ 3...');
                                console.log(response_2);
                                //alert(response_2.state);
                                //alert('response 1 parse');
                                if(response_2.state=='success'){
                                    //alert(response_2.uid);
                                    //alert('Успех регистрации');
                                    window.location.replace("sign_in.php");
                                }

                            }
                        });

                    }
                    else{
                        //alert('Провал валидации');
                        $('#name_error').html(response.name_error);
                        $('#login_error').html(response.login_error);
                        $('#password_error').html(response.password_error);
                        $('#email_error').html(response.email_error);
                        $('#phone_error').html(response.phone_error);
                    }

                }
            });

        }
    </script>
</body>
</html>
