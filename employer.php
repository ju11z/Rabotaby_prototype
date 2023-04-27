<?php
    require 'db_connect.php';
?>
<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$employer_id=$_GET['employer_id'];

$sql="select u.id as employer_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employer_id";
$employer=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
$employer=mysqli_fetch_assoc($employer);

$sql="select v.id, v.name from vacancy v where v.user_id=$employer_id";
$vacancies_list=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
$vac_num_rows=mysqli_num_rows($vacancies_list);
?>
<div class="col-12">
    <div><?php
        $uid=$_SESSION['user_id'];
        $sql="select * from user where id=$employer_id";
        $usr=mysqli_query($link, $sql);
        $usr=mysqli_fetch_array($usr);
        $lgn=$usr['user_login'];

        $filename='img\\user_profiles\\'.$lgn.'.jpg';
        $filename=str_replace("\\","/",$filename);
        ?></div>
    <div class="profile-img">
        <img class="profile-img-img" src="<?=$filename?>">
    </div>
    <div class="title text-end"><?=$employer['user_name']?></div>
    <div class="delimiter bg-light"></div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/phone.svg" alt="">
        <div class="text-with-icon-text"><?=$employer['user_phone']?></div>
    </div>
    <div class="text-with-icon">
        <img class="text-with-icon-icon" src="img/icons/email.svg" alt="">
        <div class="text-with-icon-text"><?=$employer['user_email']?></div>
    </div>
    <div class="delimiter bg-light"></div>
    <div class="text-end"> <?=$employer['user_about']?> </div>

    <div id="vacancies_list">
        <?php

        if($vac_num_rows>0){
            echo '<div class="delimiter bg-light"></div>';
            foreach ($vacancies_list as $vacancy_item){
                ?>
                <a href="employer_vacancy.php?employer_id=<?=$employer_id?>&vacancy_id=<?=$vacancy_item['id']?>"><button class="btn-1"><?=$vacancy_item['name']?></button></a>
                <?php

            }
        }
        ?>
    </div>
    <div class="delimiter bg-light"></div>
    <?php
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$employer_id){
    ?>
    <button onclick="editEmployer()">
        <div class="text-with-icon">
            <img class="text-with-icon-icon" src="img/icons/edit.svg" alt="">
            <div class="text-with-icon-text" style="color:white;">Редактировать профиль</div>
        </div>
    </button>
    <?php
        }
    ?>
</div>