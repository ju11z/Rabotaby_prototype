<?php
require 'db_connect.php';

if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}

?>
<?php
    //$employer_id=$_GET['employer_id'];
    $vacancy_id=$_GET['vacancy_id'];

    $sql="select user_id from vacancy where id=$vacancy_id";
    $employer_id=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
    $employer_id=mysqli_fetch_assoc($employer_id)['user_id'];

$sql="select v.name as vacancy_name, v.description
            ,st.title as salary_title, emt.title as employment_title, e.title as experience_title, c.title as city_title, jc.title as job_title
            from vacancy v 
            inner join job_category jc  on jc.id=v.job_category_id
            inner join salary_type st  on st.id=v.salary_type_id
            inner join employment_type emt  on emt.id=v.employment_type_id
            inner join experience_type e  on e.id=v.experience_type_id
            inner join city c on c.id=v.city_id
            inner join user u on u.id=v.user_id
            where v.id=$vacancy_id
    ";



    $vacancy=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

    $vacancy=mysqli_fetch_assoc($vacancy);

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




?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title f-orange" style="margin-bottom: 0;"><?=$vacancy['vacancy_name']?></div>
            <div class="subtitle"><?=$vacancy['job_title']?></div>
            <div class="info-row">
                <div class="info-row-item" style="margin-left:0;"><?=$vacancy['city_title']?></div>
                <div class="info-row-item"><?=$vacancy['salary_title']?></div>
                <div class="info-row-item"><?=$vacancy['employment_title']?></div>
                <div class="info-row-item"><?=$vacancy['experience_title']?></div>
            </div>
            <?php
            if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==1){
                $resume_id=$_SESSION['resume_id'];
                $sql="select * from request where vacancy_id=$vacancy_id and resume_id=$resume_id and request_type_id=1";
                $result = mysqli_query($link, $sql);
                $num_1_rows = mysqli_num_rows($result);
                if($num_1_rows!=0){
                    ?>
                    <div style="font-weight: bold; color: #7D1527; margin-top:20px;">Вы уже отправляли свое резюме на эту вакансию. Зайдите во вкладку "Отклики" и проверьте статус отклика.</div>
                    <?php
                }
                $sql="select * from request where vacancy_id=$vacancy_id and resume_id=$resume_id and request_type_id=2";
                $result = mysqli_query($link, $sql);
                $num_2_rows = mysqli_num_rows($result);
                if($num_2_rows!=0){
                    ?>
                    <div style="font-weight: bold; color: #7D1527; margin-top:20px;">Работодатель прислал вам заявку на эту вакансию. Вы можете зайти во вкладку "Отклики" и обновить статус отклика.</div>
                    <?php
                }
                if($num_1_rows==0 && $num_2_rows==0){
                    ?>
                    <div style="width:200px;" class="mt-3"><button class="btn-2" onclick="sendRequest()">Отправить резюме</button></div>
                    <?php
                }

                ?>

                <?php
            }
            ?>
            <div id='send_request_error' style="color:red; margin-top:20px;"></div>
            <div id='send_request_success' style="color:green; margin-top:20px;"></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ОПИСАНИЕ ВАКАНСИИ</div>
            <div><?=$vacancy['description']?></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">НЕОБХОДИМЫЕ НАВЫКИ</div>
            <div id="vacancy_skills">
                <?php
                if($vacancy_skills){
                    if(mysqli_num_rows($vacancy_skills)==0){
                        echo 'Кажется, для этой вакансии не нужно никаких навыков.';
                    }
                    foreach ($vacancy_skills as $vacancy_skill){
                        ?>
                        <div class="skill-container">
                            <div class="text-with-icon ">
                                <img class="text-with-icon-icon" src="img/icons/apply.svg" alt="">
                                <div class="text-with-icon-text" ><?=$vacancy_skill['skill_title']?></div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>


            <?php
            if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$employer_id){
                ?>
                <div class="delimiter bg-dark"></div>
                <button onclick="editVacancy(<?=$vacancy_id?>)">

                    <div class="text-with-icon">
                        <img class="text-with-icon-icon" src="img/icons/edit-orange.svg" alt="">
                        <div class="text-with-icon-text" >Редактировать вакансию</div>
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
        resume_id=null;
        vacancy_id= "<?php echo $vacancy_id; ?>";

        $.ajax({
            type: "POST",
            url: 'functions/print_skills.php',
            data: {vacancy_id:vacancy_id, resume_id:resume_id},
            success: function(response)
            {
                console.log(response);
                $('#vacancy_skills').html(response);
            },
            error: function (){
            }
        });
    }

    function alertWtf(){
        //alert('wtf bro');
    }
    function sendRequest(){
        vacancy_id=<?=$_GET['vacancy_id'];?>;//$( "#vacancies" ).val();
        resume_id=<?=$_SESSION['resume_id']?>;
        request_status_id=1;
        request_type_id=1;

        $.ajax({
            type: "POST",
            url: 'functions/send_request.php',
            data: {vacancy_id:vacancy_id, resume_id:resume_id, request_status_id: request_status_id, request_type_id:request_type_id},
            success: function(response)
            {
                response=JSON.parse(response);
                //alert(response.state);
                if(response.state=='success'){
                    $('#send_request_success').html('Заявка с вашим резюме на данную вакансию успешно отправлена.');
                    $('#send_request_error').html('');
                }
                else{
                    $('#send_request_success').html('');
                    $('#send_request_error').html(response.send_request_error);
                    //alert(response.send_request_error);
                }
            }
        });

    }
</script>