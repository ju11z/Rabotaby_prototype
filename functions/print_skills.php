<?php
    require '../db_connect.php';
?>
<?php
if(isset($_POST['vacancy_id'])){

    $vacancy_id=$_POST['vacancy_id'];

    $sql="select s.id as skill_id, s.title as skill_title 
            from skill s
            inner join vacancy_skill vs on vs.skill_id=s.id
            where vs.vacancy_id=$vacancy_id
        ";

    $vacancy_skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

    $sql="select s.id as skill_id, s.title as skill_title 
            from skill s
        ";

    $skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

if($vacancy_skills){
foreach ($vacancy_skills as $vacancy_skill){
    ?>
    <div class="skill-container">
        <div class="text-with-icon ">
            <img class="text-with-icon-icon" src="img/icons/apply_orange.svg" alt="">
            <div class="text-with-icon-text" ><?=$vacancy_skill['skill_title']?></div>
        </div>
        <button onclick="removeSkill(<?=$vacancy_skill['skill_id']?>)">
            <div class="text-with-icon ">
                <img class="text-with-icon-icon" src="img/icons/decline_orange.svg" alt="">
                <div class="text-with-icon-text" >Удалить навык</div>
            </div>
        </button>
    </div>
    <?php
    }
}
}
?>
<?php
if(isset($_POST['resume_id'])){

    $resume_id=$_POST['resume_id'];

    $sql="select s.id as skill_id, s.title as skill_title 
            from skill s
            inner join resume_skill rs on rs.skill_id=s.id
            where rs.resume_id=$resume_id
        ";

    $resume_skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

    $sql="select s.id as skill_id, s.title as skill_title 
            from skill s
        ";

    $skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

    if($resume_skills){
        //echo "<h1>Это навыки пользователя<h1>";
        foreach ($resume_skills as $resume_skill){
            ?>
            <div class="skill-container">
                <div class="text-with-icon ">
                    <img class="text-with-icon-icon" src="img/icons/apply_red.svg" alt="">
                    <div class="text-with-icon-text" ><?=$resume_skill['skill_title']?></div>
                </div>
                <button onclick="removeSkill(<?=$resume_skill['skill_id']?>)">
                    <div class="text-with-icon ">
                        <img class="text-with-icon-icon" src="img/icons/decline_red.svg" alt="">
                        <div class="text-with-icon-text" >Удалить навык</div>
                    </div>
                </button>
            </div>
            <?php
        }
    }
}
?>


