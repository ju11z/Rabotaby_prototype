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

/*
if(isset($_SESSION['user_id']) && isset($_POST['img'])){
    echo 'entry';
    $uid=$_SESSION['user_id'];

    if( $_FILES['file']['name'] != "" ) {
        echo $_FILES['file']['name'];
        $path=$_FILES['file']['name'];
        $pathto="/uploads/".$path;
        move_uploaded_file( $_FILES['file']['tmp_name'],$pathto) or die( "Could not copy file!");
    }
    else {
        die("No file specified!");
    }
}
*/