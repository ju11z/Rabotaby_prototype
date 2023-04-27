<?php
    require '..\db_connect.php';
?>
<?php
$response['state']='fail';

if(isset($_POST['user_type_id']) && isset($_POST['user_name']) && isset($_POST['user_login']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_phone'])) {
    $user_type_id=$_POST['user_type_id'];
    $user_name=$_POST['user_name'];
    $user_login=$_POST['user_login'];
    $user_password=$_POST['user_password'];
    $user_phone=$_POST['user_phone'];
    $user_email=$_POST['user_email'];

    $sql="insert into user (user_type_id, name, user_login, user_password, phone, email, about) values ('$user_type_id', '$user_name', '$user_login', '$user_password', '$user_phone', '$user_email','Описание о себе'  )";
    $user=mysqli_query($link, $sql);
    $uid=mysqli_insert_id($link);
    $response['uid']=$uid;

    //$uid=$user['id'];

    if($user_type_id==1){
        $sql="insert into resume (user_id,name,description,city_id, employment_type_id, experience_type_id, salary_type_id, job_category_id) values ($uid, 'Резюме без названия','Резюме без описания',1,1,1,1,1)";
        $resume=mysqli_query($link, $sql);
    }

    if($user){
        //echo 'state success';
        $response['state']='success';
    }

}

echo json_encode($response);