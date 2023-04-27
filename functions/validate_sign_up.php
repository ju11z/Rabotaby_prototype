
<?php

function validateName($user_type_id, $user_name,&$error_message){
    if($user_type_id==2 && strlen($user_name)<3 ){
        $error_message='Название компании должно быть длинной не менее 3х символов.';
        return false;
    }
    if($user_type_id==1){
        $regex="/([А-ЯЁ][а-яё]+[\-\s]?){3,}/";

        if (preg_match($regex, $user_name, $match))
        {
            $error_message='';
        }
        else
        {
            $error_message='Неверно указано ФИО.';
            return false;
        }
    }
    return true;
}

function validateLogin($user_login, &$error_message){
    require '../db_connect.php';
    if(strlen($user_login)<5){
        $error_message='Длина логина должна быть не менее 5 символов.';
        return false;
    }

    $sql="select * from user where user_login='$user_login'";
    $userlogin=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
    if(mysqli_num_rows($userlogin)>0){
        $error_message='Пользователь с таким логином уже существует.';
        return false;
    }

    return true;
}

function validatePassword($user_password,&$error_message){
    if(strlen($user_password)<5){
        $error_message='Длина пароля должна быть не менее 5 символов.';
        return false;
    }

    return true;
}

function validateEmail($user_email,&$error_message){
    $regex="/([a-zA-Z0-9]+)([\_\.\-{1}])?([a-zA-Z0-9]+)\@([a-zA-Z0-9]+)([\.])([a-zA-Z\.]+)/";

    if (preg_match($regex, $user_email, $match))
    {
        $error_message='';
    }
    else
    {
        $error_message='Почта должна быть указана в верном формате.';
        return false;
    }

    return true;
}

function validatePhone($user_phone,&$error_message){

    //$regex = "/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/";
    $regex="/^\d{3}\s\d{2}\s\d{3}\s\d{2}\s\d{2}$/";

    //$string = "111 11 111 11 11";

    if (preg_match($regex, $user_phone, $match))
    {
        $error_message='';
    }
    else
    {
        $error_message='Номер телефона должен быть в формате 111 11 111 11 11';
    }

    return true;
}

if(isset($_POST['user_type_id']) && isset($_POST['user_name']) && isset($_POST['user_login']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_phone'])){
    //$response['state']='success';
    $response['name_error']='';
    $response['login_error']='';
    $response['password_error']='';
    $response['phone_error']='';
    $response['email_error']='';

    $user_type_id=$_POST['user_type_id'];
    $user_name=$_POST['user_name'];
    $user_login=$_POST['user_login'];
    $user_password=$_POST['user_password'];
    $user_phone=$_POST['user_phone'];
    $user_email=$_POST['user_email'];

    if(validateName($user_type_id, $user_name, $response['name_error'])
    & validateLogin($user_login,$response['login_error'])
    & validatePassword($user_password,$response['password_error'])
    & validateEmail($user_email,$response['email_error'])
    & validatePhone($user_phone,$response['phone_error'])){
        $response['state']='success';
    }
    else{
        $response['state']='fail';
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}


