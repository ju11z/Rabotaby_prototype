<?php
$response['state']='success';
$response['name_error']='';
$response['about_error']='';
$response['phone_error']='';
$response['email_error']='';

$employee_name=$_POST['employee_name'];
$employee_about=$_POST['employee_about'];
$employee_phone=$_POST['employee_phone'];
$employee_email=$_POST['employee_email'];

function validateName($user_name,&$error_message){

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

    return true;
}

function validateDescription($user_about,&$error_message){
    if(strlen($user_about)<20){
        $error_message='Длина описания должна быть не менее 20 символов.';
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

    $regex="/^\d{3}\s\d{2}\s\d{3}\s\d{2}\s\d{2}$/";

    if (preg_match($regex, $user_phone, $match))
    {
        $error_message='';
    }
    else
    {
        $error_message='Номер телефона должен быть указан в формате 111 11 111 11 11.';
    }

    return true;
}

if(validateName( $employee_name, $response['name_error'])
    & validateEmail($employee_email,$response['email_error'])
    & validatePhone($employee_phone,$response['phone_error'])
    & validateDescription($employee_about,$response['about_error'])
    )
{
    $response['state']='success';
}
else{
    $response['state']='fail';
}


echo json_encode($response);
