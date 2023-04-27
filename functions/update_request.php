<?php require '../db_connect.php'?>
<?php
if(isset($_POST['request_id']) && isset($_POST['request_status_id'])){
    $request_id=$_POST['request_id'];
    $request_status_id=$_POST['request_status_id'];

    $date_responded=date('Y-m-d H:i:s');

    $sql="update request set request_status_id=$request_status_id, date_responded='$date_responded' where id=$request_id";
    $result=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
}