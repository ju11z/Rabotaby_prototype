<?php
    require '../db_connect.php';
?>


<?php
if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}

$response['state']='success';
$response['send_request_error']='';

if(isset($_POST['resume_id']) && isset($_POST['vacancy_id']) && isset($_POST['request_type_id'])){
    $resume_id=$_POST['resume_id'];
    $vacancy_id=$_POST['vacancy_id'];
    $request_type_id=$_POST['request_type_id'];
    $request_status_id=1;


    if($_SESSION['user_type_id']==1){
        $sql="select * from request where vacancy_id=$vacancy_id and resume_id=$resume_id and request_type_id=1";
        $result=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
        $num_rows=mysqli_num_rows($result);
        if($num_rows!=0){
            $response['state']='fail';
            $response['send_request_error']="Вы уже отправляли резюме на эту вакансию. Зайдите во вкладку 'Отклики' и проверьте статус отклика от работодателя.";
        }
        if($num_rows==0){
            $date_sent=date('Y-m-d H:i:s');
            $sql="insert into request (vacancy_id, resume_id, request_status_id, request_type_id,date_sent) values ($vacancy_id,$resume_id,$request_status_id, $request_type_id, '$date_sent')";
            $request=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
            $response['state']='success';
            $response['send_request_error']='';
        }



    }

    if($_SESSION['user_type_id']==2){
        $sql="select * from request where vacancy_id=$vacancy_id and resume_id=$resume_id and request_type_id=1";
        $result=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
        $num_1_rows=mysqli_num_rows($result);
        if($num_1_rows!=0){
            $response['state']='fail';
            $response['send_request_error']="Работник уже отправил вам свое резюме на юту вакансию. Зайдите во вкладку 'Отклики' и обновите статус отклика.";
        }

        $sql="select * from request where vacancy_id=$vacancy_id and resume_id=$resume_id and request_type_id=2";
        $result=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
        $num_2_rows=mysqli_num_rows($result);
        if($num_2_rows!=0){
            $response['state']='fail';
            $response['send_request_error']="Вы уже отправляли вакансию на это резюме. Зайдите во вкладку 'Отклики' и проверьте статус отклика от работника.";
        }

        if($num_1_rows==0 && $num_2_rows==0){
            $date_sent=date('Y-m-d H:i:s');
            $sql="insert into request (vacancy_id, resume_id, request_status_id, request_type_id,date_sent) values ($vacancy_id,$resume_id,$request_status_id, $request_type_id, '$date_sent')";
            $request=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
            $response['state']='success';
            $response['send_request_error']='';
        }


    }



}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
