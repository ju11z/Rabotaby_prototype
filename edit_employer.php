<?php
require 'db_connect.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

$employer_id=$_GET['employer_id'];

$sql="select u.id as employer_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employer_id";
$employer=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
$employer=mysqli_fetch_assoc($employer);

$sql="select v.id, v.name from vacancy v where v.user_id=$employer_id";
$vacancies_list=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

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
    </div>
    <input class="title text-end profile-input mt-3" value="<?=$employer['user_name']?>" id="edit_company_name"></input>
    <div class="edit-profile-error" id="name_error"></div>
    <div class="delimiter bg-light"></div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/phone.svg" alt="">
        <input class="text-with-icon-text profile-input" id="edit_company_phone" value="<?=$employer['user_phone']?>"></input>
    </div>
    <div class="edit-profile-error" id="phone_error"></div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/email.svg" alt="">
        <input class="text-with-icon-text profile-input" id="edit_company_email" value="<?=$employer['user_email']?>"></input>
    </div>
    <div class="edit-profile-error" id="email_error"></div>
    <div class="delimiter bg-light" style="margin-top:0px;"></div>
    <input class="text-end profile-input" id="edit_company_about" value="<?=$employer['user_about']?>">  </input>
    <div class="edit-profile-error" id="about_error"></div>
    <div class="delimiter bg-light"></div>
    <div id="vacancies_list">
        <?php
        if($vacancies_list){
            foreach ($vacancies_list as $vacancy_item){
                ?>
                <a href="employer_vacancy.php?employer_id=<?=$employer_id?>&vacancy_id=<?=$vacancy_item['id']?>"><button class="btn-1"><?=$vacancy_item['name']?></button></a>
                <?php

            }
        }
        ?>
    </div>
    <?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$employer_id){
        ?>
        <button onclick="createVacancy()" >
            <div class="text-with-icon mt-5">
                <img class="text-with-icon-icon" src="img/icons/add.svg" alt="">
                <div class="text-with-icon-text" style="color:white;">Добавить вакансию</div>
            </div>
        </button>
        <?php
    }
    ?>
    <div class="delimiter bg-light"></div>
    <?php?>
    <button onclick="trySaveEmployer()">
        <div class="text-with-icon">
            <img class="text-with-icon-icon" src="img/icons/edit.svg" alt="">
            <div class="text-with-icon-text" style="color:white;">Сохранить профиль</div>
        </div>
    </button>
    <?php?>
</div>
