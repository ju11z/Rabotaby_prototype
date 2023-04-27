<?php
require 'db_connect.php';
if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}
?>
<?php
$vacancy_id=$_GET['vacancy_id'];
$employer_id=$_GET['vacancy_id'];

$sql="select v.name as vacancy_name, v.description, jc.title as job_title,
            st.title as salary_title, emt.title as employment_title, e.title as experience_title, c.title as city_title,
            c.id as city_id, st.id as salary_id, emt.id as employment_id, e.id as experience_id, jc.id as job_id
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
            <input id="edit_vacancy_name" value="<?=$vacancy['vacancy_name']?>" class="title f-orange" style="margin-bottom:0px;" >
            <div class="error-block" id="name_error"></div>
            <?php
            if($jobs){
                echo "<select id='edit_vacancy_job' style='margin-bottom:30px;'>";
                foreach($jobs as $job){
                    $id=$job['id'];
                    if($id==$vacancy['job_id']){
                        echo "<option value='$id' selected='selected'>".$job['title']."</option>";
                    }
                    else{
                        echo "<option value='$id'>".$job['title']."</option>";
                    }

                }
                echo '</select>';
            }
            ?>
            <div class="info-row">
                <?php
                    if($cities){
                        echo "<select id='edit_vacancy_city'>";
                        foreach($cities as $city){
                            $id=$city['id'];
                            if($id==$vacancy['city_id']){
                                echo "<option value='$id' selected='selected'>".$city['title']."</option>";
                            }
                            else{
                                echo "<option value='$id'>".$city['title']."</option>";
                            }

                        }
                        echo '</select>';
                    }
                ?>
                <?php
                if($salarys){
                    echo "<select id='edit_vacancy_salary'>";
                    foreach($salarys as $salary){
                        $id=$salary['id'];
                        if($id==$vacancy['salary_id']){
                            echo "<option value='$id' selected='selected'>".$salary['title']."</option>";
                        }
                        else{
                            echo "<option value='$id'>".$salary['title']."</option>";
                        }
                    }
                    echo '</select>';
                }
                ?>
                <?php
                if($employments){
                    echo "<select id='edit_vacancy_employment'>";;
                    foreach($employments as $employment){
                        $id=$employment['id'];
                        if($id==$vacancy['employment_id']){
                            echo "<option value='$id' selected='selected'>".$employment['title']."</option>";
                        }
                        else{
                            echo "<option value='$id'>".$employment['title']."</option>";
                        }
                    }
                    echo '</select>';
                }
                ?>
                <?php
                if($experiences){
                    echo "<select style='margin-right:0;' id='edit_vacancy_experience' >";
                    foreach($experiences as $experience){
                        $id=$experience['id'];
                        if($id==$vacancy['experience_id']){
                            echo "<option value='$id' selected='selected'>".$experience['title']."</option>";
                        }
                        else{
                            echo "<option value='$id'>".$experience['title']."</option>";
                        }
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ОПИСАНИЕ ВАКАНСИИ</div>
            <textarea text="" id="edit_vacancy_descr" value="<?=$vacancy['description']?>"><?=$vacancy['description']?></textarea>
            <div class="error-block" id="descr_error"></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">НЕОБХОДИМЫЕ НАВЫКИ</div>
            <div id="vacancy_skills">
                <?php
                if($vacancy_skills){
                    foreach ($vacancy_skills as $vacancy_skill){
                        ?>
                        <div class="skill-container">
                            <div class="text-with-icon ">
                                <img class="text-with-icon-icon" src="img/icons/apply.svg" alt="">
                                <div class="text-with-icon-text" ><?=$vacancy_skill['skill_title']?></div>
                            </div>
                            <button onclick="removeSkill(<?=$vacancy_skill['skill_id']?>)">
                                <div class="text-with-icon ">
                                    <img class="text-with-icon-icon" src="img/icons/decline.svg" alt="">
                                    <div class="text-with-icon-text" >Удалить навык</div>
                                </div>
                            </button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="skill-container mt-5">
                <select name="" id="skills" style="max-width:200px;">
                    <?php
                    if($skills){
                        foreach ($skills as $skill){
                            ?>
                            <option value="<?=$skill['id']?>"><?=$skill['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <button onclick="addSkill()" id="add-btn">
                    <div class="text-with-icon ">
                        <img  src="img/icons/add-orange.svg"  class="text-with-icon-icon" alt="">
                        <div class="text-with-icon-text">Добавить навык</div>
                    </div>
                </button>
            </div>
            <div class="error-block" id="skill_error"></div>
            <div id="add_skill_error"></div>
            <div class="delimiter bg-dark"></div>
            <button onclick="trySaveVacancy(<?=$vacancy_id?>)">
                <div class="text-with-icon">
                    <img class="text-with-icon-icon" src="img/icons/edit-orange.svg" alt="">
                    <div class="text-with-icon-text" >Сохранить вакансию</div>
                </div>
            </button>
        </div>
    </div>
    </div>
<script src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>




    function addSkill(){
        //alert('Попытка добавить навык...');
        skill_id=$( "#skills" ).val();
        vacancy_id=<?=$vacancy_id?>;
        console.log(skill_id, vacancy_id);

        $.ajax({
            type: "POST",
            url: 'functions/add_skill.php',
            data: {vacancy_id:vacancy_id,  skill_id:skill_id},
            success: function(response)
            {
                console.log(response);
                response=JSON.parse(response);
                console.log(response.state);
                if(response.state=='success'){
                    //alert('Навык успешно добавлен!');
                    printSkills();
                }
                else{
                    $('#skill_error').html(response['error']);
                }

            },
            error: function () {
            }
        });
    }

    function removeSkill(skill_id){
        //alert('Попытка удалить навык...');

        vacancy_id=<?=$vacancy_id?>;
        console.log(skill_id, vacancy_id);

        $.ajax({
            type: "POST",
            url: 'functions/remove_skill.php',
            data: {vacancy_id:vacancy_id,skill_id:skill_id},
            success: function(response)
            {
                console.log(response);
                response=JSON.parse(response);
                console.log(response.state);
                if(response.state=='success'){
                    //alert('Навык успешно удален!');
                    printSkills();
                }
                else{
                    $('#delete_skill_error').html(response['error']);
                }

            },
            error: function () {
            }
        });
    }

    function printSkills(){

        $.ajax({
            type: "POST",
            url: 'functions/print_skills.php',
            data: {vacancy_id:vacancy_id},
            success: function(response)
            {
                console.log(response);
                $('#vacancy_skills').html(response);
            },
            error: function () {
            }
        });
    }
</script>
