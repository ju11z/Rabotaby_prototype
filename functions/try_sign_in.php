<?php
require '..\db_connect.php';
?>



<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response['state']='fail';
$response['sign_in_error']='';
$response['user_type_id']=1;

if(isset($_POST['login']) && isset($_POST['password']) ) {

    $login=$_POST['login'];
    $password=$_POST['password'];

    //echo $login;
    //echo $password;

    $sql="select * from user where user_login='$login' and user_password='$password'";
    $user=mysqli_query($link, $sql);

    //echo mysqli_num_rows($user);

    if(mysqli_num_rows($user)==1){
        $response['state']='success';

        $user_info=mysqli_fetch_array($user);

        $_SESSION['user_id']=$user_info['id'];
        $_SESSION['user_type_id']=$user_info['user_type_id'];
        $response['user_type_id']=$_SESSION['user_type_id'];

        if($_SESSION['user_type_id']==1){
            $uid=$_SESSION['user_id'];

            $sql="select * from resume where user_id=$uid";
            $resume=mysqli_query($link, $sql);
            $resume_info=mysqli_fetch_array($resume);
            $resume_id= $resume_info['id'];
            $_SESSION['resume_id']=$resume_id;

            //echo $_SESSION['resume_id'];
        }
    }
    else{
        $response['sign_in_error']='Такой пользователь не найден.';
    }

}

echo json_encode($response);