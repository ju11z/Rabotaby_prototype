<?php
require 'db_connect.php';
?>
<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$employee_id=$_GET['employee_id'];

$sql="select u.id as employee_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employee_id";
$employee=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
$employee=mysqli_fetch_assoc($employee);

//$sql="select v.id, v.name from vacancy v where v.user_id=$employer_id";
//$vacancies_list=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
?>
<div class="col-12">
<div >
    <?php
    $uid=$_SESSION['user_id'];
    $sql="select * from user where id=$employee_id";
    $usr=mysqli_query($link, $sql);
    $usr=mysqli_fetch_array($usr);
    $lgn=$usr['user_login'];

    $filename='img\\user_profiles\\'.$lgn.'.jpg';
    $filename=str_replace("\\","/",$filename);
    ?>
</div>
<div class="profile-img">
    <img class="profile-img-img" src="<?=$filename?>">
</div>
    <div class="title text-end"><?=$employee['user_name']?></div>
    <div class="delimiter bg-light"></div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/phone.svg" alt="">
        <div class="text-with-icon-text"><?=$employee['user_phone']?></div>
    </div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/email.svg" alt="">
        <div class="text-with-icon-text"><?=$employee['user_email']?></div>
    </div>
    <div class="delimiter bg-light"></div>
    <div class="text-end"> <?=$employee['user_about']?> </div>
    <div class="delimiter bg-light"></div>

    <?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$employee_id){
        ?>
        <button onclick="editEmployee()">
            <div class="text-with-icon">
                <img class="text-with-icon-icon" src="img/icons/edit.svg" alt="">
                <div class="text-with-icon-text" style="color:white;">Редактировать профиль</div>
            </div>
        </button>
        <?php
    }
    ?>
</div>