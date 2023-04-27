<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 pt-3 pb-3 text-center" style="background-color: #1c1f23; color:white;"><div class="title">ВХОД</div></div>
    </div>
    <div class="row mt-5">
        <div class="col-3"></div>
        <div class="col-6">
            <h5 class="mb-3 mb-5"><a link href="sign_up.php">Впервые здесь? Зарегистрируйтесь!</a></h5>
            <div class="mt-5">
                <label for="">Логин</label>
                <input type="text" placeholder="Введите логин" name="login" id="login" class="sign-form">
            </div>
            <div class="mt-3">
                <label for="">Пароль</label>
                <input type="text" placeholder="Введите пароль" name="password" id="password" class="sign-form">
            </div>
            <div id="sign_in_error"></div>
            <button onclick="trySignIn()" class="form-button mt-5">Войти</button>

        </div>
        <div class="col-3"></div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script>
    function trySignIn(){
        login=$('#login').val();
        password=$('#password').val();

        $.ajax({
            type:"POST",
            url: "functions/try_sign_in.php",
            data:{login:login, password:password},
            success:function (response){
                response=JSON.parse(response);
                if(response.state=='success'){
                    //alert('Успех входа');
                    if(response.user_type_id==1){
                        window.location.replace("search_vacancy.php");
                    }
                    if(response.user_type_id==2){
                        window.location.replace("search_resume.php");
                    }

                }else{
                    $('#sign_in_error').html(response.sign_in_error);
                }

            }
        });
    }
</script>
<script></script>
</body>
</html>