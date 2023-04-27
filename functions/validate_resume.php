<?php
$response['state']='success';
$response['name_error']='';
$response['descr_error']='';

$resume_name=$_POST['resume_name'];
$resume_descr=$_POST['resume_descr'];

if(strlen($resume_name)<5){
    $response['state']='fail';
    $response['name_error']='Длина названия резюме должна быть более 5 символов.';
}

if(strlen($resume_descr)<20){
    $response['state']='fail';
    $response['descr_error']='Длина описания резюме должна быть более 20 символов.';
}

echo json_encode($response);
