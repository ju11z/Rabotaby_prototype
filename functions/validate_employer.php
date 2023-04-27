<?php
$response['state']='success';
$response['name_error']='';
$response['about_error']='';
$response['phone_error']='';
$response['email_error']='';

$company_name=$_POST['company_name'];
$company_about=$_POST['company_about'];
$company_phone=$_POST['company_phone'];
$company_email=$_POST['company_email'];

function validateName($user_name,&$error_message){

    if(strlen($user_name)<3){
        $error_message='Длина названия компании должна быть не менее 3х символов.';
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

if(validateName( $company_name, $response['name_error'])
    & validateEmail($company_email,$response['email_error'])
    & validatePhone($company_phone,$response['phone_error'])
    & validateDescription($company_about,$response['about_error'])
)
{
    $response['state']='success';
}
else{
    $response['state']='fail';
}


echo json_encode($response);
