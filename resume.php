<?php
require 'db_connect.php';

if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}

?>
<?php
if(isset($_GET['employee_id'])){
    //echo 'есть работник ид';
    $employee_id=$_GET['employee_id'];
}
if(isset($_GET['resume_id'])){
    //echo 'есть резюме ид';
    $resume_id=$_GET['resume_id'];
}else{
    if(isset($_SESSION['resume_id']) && $employee_id==$_SESSION['user_id']){
        $resume_id=$_SESSION['resume_id'];
    }
}


//$sql="select user_id from vacancy where id=$resume_id";
//$employer_id=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
//$employer_id=mysqli_fetch_assoc($employer_id)['user_id'];

$sql="select r.name as resume_name, r.description, jc.title as job_title,
            st.title as salary_title, emt.title as employment_title, e.title as experience_title, c.title as city_title, jc.title as job_title
            from resume r 
            inner join job_category jc  on jc.id=r.job_category_id
            inner join salary_type st  on st.id=r.salary_type_id
            inner join employment_type emt  on emt.id=r.employment_type_id
            inner join experience_type e  on e.id=r.experience_type_id
            inner join city c on c.id=r.city_id
            inner join user u on u.id=r.user_id
            where r.id=$resume_id
    ";

//echo $sql;

$resume=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$resume=mysqli_fetch_assoc($resume);
//var_dump($resume);

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



?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title f-red" style="margin-bottom: 0;"><?=$resume['resume_name']?></div>
            <div class="subtitle"><?=$resume['job_title']?></div>
            <div class="info-row">
                <div class="info-row-item" style="margin-left:0;"><?=$resume['city_title']?></div>
                <div class="info-row-item"><?=$resume['salary_title']?></div>
                <div class="info-row-item"><?=$resume['employment_title']?></div>
                <div class="info-row-item"><?=$resume['experience_title']?></div>
            </div>
            <?php
            if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==2){

                $user_id=$_SESSION['user_id'];
                $sql="select v.id, v.name from vacancy v where v.user_id=$user_id";
                $vacancies_list=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
                $vac_num_rows=mysqli_num_rows($vacancies_list);
                if($vac_num_rows>0){
                    echo "<div class='delimiter bg-dark'></div>";
                    echo "<div>Заинтересовало резюме? Отправьте свою заявку работнику с вашей прикрепленной вакансией!</div>";
                    echo "<div style='display: flex; flex-direction: row; margin-top:20px;'>";
                    echo "<select id='vacancies' style='width:200px; margin-right:50px;'>";
                    foreach ($vacancies_list as $vacancy){
                        ?>
                        <option value="<?=$vacancy['id']?>"><?=$vacancy['name']?></option>
                        <?php
                    }
                    echo '</select>';
                    echo "<div style='width:200px;' class='mt-3'><button class='btn-2' onclick='sendRequest()'>Отправить вакансию</button></div>";
                    echo "</div>";
                }
                ?>

                <?php


            }
            ?>
            <div id='send_request_error' style="color:red; margin-top:20px;"></div>
            <div id='send_request_success' style="color:green; margin-top:20px;"></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ОПИСАНИЕ РЕЗЮМЕ</div>
            <div><?=$resume['description']?></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ПРИСУТСТВУЮЩИЕ НАВЫКИ</div>
            <div id="resume_skills">
                <?php
                if($resume_skills){
                    if(mysqli_num_rows($resume_skills)==0){
                        echo 'Кажется, у автора этого резюме не указано никаких навыков.';
                    }
                    foreach ($resume_skills as $resume_skill){
                        ?>
                        <div class="skill-container">
                            <div class="text-with-icon ">
                                <img class="text-with-icon-icon" src="img/icons/apply_red.svg" alt="">
                                <div class="text-with-icon-text" ><?=$resume_skill['skill_title']?></div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>


            <?php

            if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$employee_id){
                ?>
                <div class="delimiter bg-dark"></div>
                <button onclick="editResume(<?=$resume_id?>)">

                    <div class="text-with-icon">
                        <img class="text-with-icon-icon" src="img/icons/edit_red.svg" alt="">
                        <div class="text-with-icon-text" >Редактировать резюме</div>
                    </div>
                </button>
                <?php
            }
            ?>


        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script>
    $(document).ready(function(){
        //alert('Вывод в первый раз?');
        //printSkills();
    });

    function printSkills(){
        resume_id=<?=$resume_id?>;

        $.ajax({
            type: "POST",
            url: 'functions/print_skills.php',
            data: {resume_id:resume_id},
            success: function(response)
            {
                console.log(response);
                $('#resume_skills').html(response);
            },
            error: function () {
            }
        });
    }

    function sendRequest(){
        vacancy_id=$( "#vacancies" ).val();
        resume_id=<?=$resume_id?>;
        request_status_id=1;
        request_type_id=2;

        $.ajax({
            type: "POST",
            url: 'functions/send_request.php',
            data: {vacancy_id:vacancy_id, resume_id:resume_id, request_status_id: request_status_id, request_type_id:request_type_id},
            success: function(response)
            {
                response=JSON.parse(response);
                //alert(response.state);
                if(response.state=='success'){
                    $('#send_request_error').html('');
                    $('#send_request_success').html('Заявка для данной вакансии на это резюме успешно отправлена.');
                }
                else{
                    $('#send_request_error').html(response.send_request_error);
                    $('#send_request_success').html('');
                    //alert(response.send_request_error);
                }
            }
        });

    }
</script>