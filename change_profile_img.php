<?php
require '../db_connect.php';

if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}
?>
<?php
$uid=$_SESSION['user_id'];
$sql="select * from user where id=$uid";
$usr=mysqli_query($link, $sql);
$usr=mysqli_fetch_array($usr);
$lgn=$usr['user_login'];


if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    //move_uploaded_file($_FILES['file']['tmp_name'], '../img/user_profiles/' . $_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], '../img/user_profiles/' . $_FILES['file']['name']);
    rename('../img/user_profiles/' . $_FILES['file']['name'],'../img/user_profiles/' . $lgn .'.jpg');
}



?>
