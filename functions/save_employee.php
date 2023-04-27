<?php
require '..\db_connect.php';
?>
<?php
if(isset($_POST['employee_id'])){
    $employee_id=$_POST['employee_id'];

    if(isset($_POST['employee_name'])){
        $employee_name=$_POST['employee_name'];
        $sql="update user set name='$employee_name' where id=$employee_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['employee_about'])){
        $employee_about=$_POST['employee_about'];
        $sql="update user set about='$employee_about' where id=$employee_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['employee_phone'])){
        $employee_phone=$_POST['employee_phone'];
        $sql="update user set phone='$employee_phone' where id=$employee_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['employee_email'])){
        $employee_email=$_POST['employee_email'];
        $sql="update user set email='$employee_email' where id=$employee_id";
        $res=mysqli_query($link, $sql);
    }
}
