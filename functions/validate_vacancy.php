<?php
$response['state']='success';
$response['name_error']='';
$response['descr_error']='';

$vacancy_name=$_POST['vacancy_name'];
$vacancy_descr=$_POST['vacancy_descr'];

if(strlen($vacancy_name)<5){
    $response['state']='fail';
    $response['name_error']='Длина названия вакансии болжна быть более 5 символов.';
}

if(strlen($vacancy_descr)<20){
    $response['state']='fail';
    $response['descr_error']='Длина описания вакансии болжна быть более 20 символов.';
}

echo json_encode($response);
