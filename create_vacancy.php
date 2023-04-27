<?php
require 'db_connect.php';
if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}
?>
<?php
//$vacancy_id=$_GET['vacancy_id'];
$employer_id=$_GET['employer_id'];


$sql="select s.id, s.title
            from skill s
        ";

$skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select c.id, c.title
            from city c
        ";

$cities=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select s.id, s.title
            from salary_type s
        ";

$salarys=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select e.id, e.title 
            from experience_type e
        ";

$experiences=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select e.id, e.title
            from employment_type e
        ";

$employments=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select jc.id, jc.title from job_category jc";

$jobs=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));




?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div id="printText"></div>
            <input id="add_vacancy_name" value="" class="title f-orange" style="margin-bottom:0px;" >
            <div class="error-block" id="name_error"></div>
            <?php
            if($jobs){
                echo "<select id='add_vacancy_job' style='margin-bottom:30px;'>";
                foreach($jobs as $job){
                    $id=$job['id'];
                    echo "<option value='$id' selected='selected'>".$job['title']."</option>";
                }
                echo '</select>';
            }
            ?>


            <div class="info-row">
                <?php
                if($cities){
                    echo "<select id='add_vacancy_city'>";
                    foreach($cities as $city){
                        $id=$city['id'];
                        echo "<option value='$id'>".$city['title']."</option>";


                    }
                    echo '</select>';
                }
                ?>
                <?php
                if($cities){
                    echo "<select id='add_vacancy_salary'>";
                    foreach($salarys as $salary){
                        $id=$salary['id'];


                            echo "<option value='$id'>".$salary['title']."</option>";

                    }
                    echo '</select>';
                }
                ?>
                <?php
                if($cities){
                    echo "<select id='add_vacancy_employment'>";;
                    foreach($employments as $employment){
                        $id=$employment['id'];

                            echo "<option value='$id'>".$employment['title']."</option>";

                    }
                    echo '</select>';
                }
                ?>
                <?php
                if($cities){
                    echo "<select style='margin-right:0;' id='add_vacancy_experience' >";
                    foreach($experiences as $experience){
                        $id=$experience['id'];

                            echo "<option value='$id'>".$experience['title']."</option>";

                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ОПИСАНИЕ ВАКАНСИИ</div>
            <textarea text="" id="add_vacancy_descr" value=""></textarea>
            <div class="error-block" id="descr_error"></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">НЕОБХОДИМЫЕ НАВЫКИ</div>
            <div>Навыки вы сможете добавить при сохранении этой вакансии и повторном ее редактировании.</div>
            <div class="error-block" id="skill_error"></div>
            <div id="add_skill_error"></div>
            <div class="delimiter bg-dark"></div>
            <button onclick="tryAddVacancy()">
                <div class="text-with-icon">
                    <img class="text-with-icon-icon" src="img/icons/edit-orange.svg" alt="">
                    <div class="text-with-icon-text" >Добавить вакансию</div>
                </div>
            </button>
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script>


</script>
