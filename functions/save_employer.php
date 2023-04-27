<?php
require '..\db_connect.php';
?>
<?php
if(isset($_POST['employer_id'])){
    $employer_id=$_POST['employer_id'];

    if(isset($_POST['company_name'])){
        $company_name=$_POST['company_name'];
        $sql="update user set name='$company_name' where id=$employer_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['company_about'])){
        $company_about=$_POST['company_about'];
        $sql="update user set about='$company_about' where id=$employer_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['company_phone'])){
        $company_phone=$_POST['company_phone'];
        $sql="update user set phone='$company_phone' where id=$employer_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['company_email'])){
        $company_email=$_POST['company_email'];
        $sql="update user set email='$company_email' where id=$employer_id";
        $res=mysqli_query($link, $sql);
    }
}
