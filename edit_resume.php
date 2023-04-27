<?php
require 'db_connect.php';
if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}
?>
<?php
$resume_id=$_GET['resume_id'];
//$employee_id=$_GET['employee_id'];

$sql="select r.name as resume_name, r.description
            ,st.id as salary_id, emt.id as employment_id, e.id as experience_id, c.id as city_id, jc.id as job_id
            ,st.title as salary_title, emt.title as employment_title, e.title as experience_title, c.title as city_title,jc.title as job_title
            from resume r 
            inner join job_category jc  on jc.id=r.job_category_id
            inner join salary_type st  on st.id=r.salary_type_id
            inner join employment_type emt  on emt.id=r.employment_type_id
            inner join experience_type e  on e.id=r.employment_type_id
            inner join city c on c.id=r.city_id
            inner join user u on u.id=r.user_id
            where r.id=$resume_id
    ";

$resume=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$resume=mysqli_fetch_assoc($resume);

//var_dump($resume);

$sql="select s.id as skill_id, s.title as skill_title 
            from skill s
            inner join resume_skill rs on rs.skill_id=s.id
            where rs.resume_id=$resume_id
        ";

$resume_skills=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

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

//echo "<br>".$resume['city_title']."</br>";
//echo "<br>".$resume['salary_title']."</br>";
//echo "<br>".$resume['employment_title']."</br>";
//echo "<br>".$resume['experience_title']."</br>";


?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div id="printText"></div>
            <input id="edit_resume_name" value="<?=$resume['resume_name']?>" class="title f-red" style="margin-bottom:0px;" >
            <div class="error-block" id="name_error"></div>
            <?php
                if($jobs){
                    echo "<select id='edit_resume_job' style='margin-bottom:30px;'>";
                    foreach($jobs as $job){
                        $id=$job['id'];
                        if($id==$resume['job_id']){
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
                    echo "<select id='edit_resume_city'>";
                    foreach($cities as $city){
                        $id=$city['id'];
                        if($id==$resume['city_id']){
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
                    echo "<select id='edit_resume_salary'>";
                    foreach($salarys as $salary){
                        $id=$salary['id'];
                        if($id==$resume['salary_id']){
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
                    echo "<select id='edit_resume_employment'>";;
                    foreach($employments as $employment){
                        $id=$employment['id'];
                        if($id==$resume['employment_id']){
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
                    echo "<select style='margin-right:0;' id='edit_resume_experience' >";
                    foreach($experiences as $experience){
                        $id=$experience['id'];
                        if($id==$resume['experience_id']){
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
            <div class="title">ОПИСАНИЕ РЕЗЮМЕ</div>
            <textarea text="" id="edit_resume_descr" value="<?=$resume['description']?>"><?=$resume['description']?></textarea>
            <div class="error-block" id="descr_error"></div>
            <div class="delimiter bg-dark"></div>
            <div class="title">ПРИСУТСТВУЮЩИЕ НАВЫКИ</div>
            <div id="resume_skills">
                <?php
                if($resume_skills){
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
                        <img  src="img/icons/add_red.svg"  class="text-with-icon-icon" alt="">
                        <div class="text-with-icon-text">Добавить навык</div>
                    </div>
                </button>
            </div>
            <div class="error-block" id="skill_error"></div>
            <div id="add_skill_error"></div>
            <div class="delimiter bg-dark"></div>
            <button onclick="trySaveResume(<?=$resume_id?>)">
                <div class="text-with-icon">
                    <img class="text-with-icon-icon" src="img/icons/edit_red.svg" alt="">
                    <div class="text-with-icon-text" >Сохранить резюме</div>
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
        resume_id=<?=$resume_id?>;
        console.log(skill_id, resume_id);

        $.ajax({
            type: "POST",
            url: 'functions/add_skill.php',
            data: {resume_id:resume_id, skill_id:skill_id},
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

        resume_id=<?=$resume_id?>;
        console.log(skill_id, resume_id);

        $.ajax({
            type: "POST",
            url: 'functions/remove_skill.php',
            data: {resume_id:resume_id, skill_id:skill_id},
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
</script>
