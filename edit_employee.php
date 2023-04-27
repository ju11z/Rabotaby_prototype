<?php
require 'db_connect.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

$employee_id=$_GET['employee_id'];

$sql="select u.id as employee_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employee_id";
$employee=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
$employee=mysqli_fetch_assoc($employee);


?>
<div class="col-12">
    <?php
    $uid=$_SESSION['user_id'];
    $sql="select * from user where id=$uid";
    $usr=mysqli_query($link, $sql);
    $usr=mysqli_fetch_array($usr);
    $lgn=$usr['user_login'];

    $filename='img\\user_profiles\\'.$lgn.'.jpg';
    $filename=str_replace("\\","/",$filename);

    ?>
    <div class="profile-img">
        <img class="profile-img-img" src="<?=$filename?>">
    </div>
    <input id="profileImg" type="file" class="mt-3" accept="image/png, image/jpg, image/jpeg" >
    <button onclick="trySaveEmployee()">
        <div class="text-with-icon">
            <img class="text-with-icon-icon" src="img/icons/edit.svg" alt="">
            <div class="text-with-icon-text" style="color:white;">Сохранить профиль</div>
        </div>
    </button>
<input class="title text-end profile-input mt-3" value="<?=$employee['user_name']?>" id="edit_employee_name"></input>
<div class="edit-profile-error" id="employee_name_error"></div>
<div class="delimiter bg-light"></div>
<div class="text-with-icon">
    <img class="text-with-icon-icon" src="img/icons/phone.svg" alt="">
    <input class="text-with-icon-text profile-input" id="edit_employee_phone" value="<?=$employee['user_phone']?>"></input>
</div>
<div class="edit-profile-error" id="phone_error"></div>
<div class="text-with-icon">
    <img class="text-with-icon-icon" src="img/icons/email.svg" alt="">
    <input class="text-with-icon-text profile-input" id="edit_employee_email" value="<?=$employee['user_email']?>"></input>
</div>
<div class="edit-profile-error" id="email_error"></div>
<div class="delimiter bg-light" style="margin-top:0px;"></div>
<input class="text-end profile-input" id="edit_employee_about" value="<?=$employee['user_about']?>">  </input>
<div class="edit-profile-error" id="about_error"></div>
<div class="delimiter bg-light"></div>
<?php?>
<button onclick="trySaveEmployee()">
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/edit.svg" alt="">
        <div class="text-with-icon-text" style="color:white;">Сохранить профиль</div>
    </div>
</button>
<?php?>
</div>
