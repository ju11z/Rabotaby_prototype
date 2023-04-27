<?php
    require 'db_connect.php';
?>
<?php
require 'menu.php';
?>
<?php


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

?>

<!doctype html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
</head>
<body>
<div class="container">
    <div class="row mb-5 mt-5" style="height:120px; background-color: #E3973E;">
        <div class="col-2"></div>
        <div class="col-8" style="display:flex; flex-direction: row; justify-content: space-between; align-items: center;">
            <div class="input-block">
                <input type="text" id="search_text">
                <img src="img/icons/search_orange.svg" alt="" onclick="filterResumes()">
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="title-small">ПОИСК ПО ТЕКСТУ</div>
            <div class="checkbox-block">
                <input type="checkbox" class="chck" id="search_employee_name">
                <div>Искать в имени пользователя</div>
            </div>
            <div class="checkbox-block">
                <input type="checkbox" class="chck" id="search_resume_name">
                <div>Искать в названии резюме</div>
            </div>
            <div class="checkbox-block">
                <input type="checkbox" class="chck" id="search_resume_descr">
                <div>Искать в описании резюме</div>
            </div>
            <div class="delimiter bg-dark"></div>

            <div class="title-small">КАТЕГОРИЯ РАБОТЫ</div>
            <button class="btn-2" style="width:100%; background-color: #E3973E;" data-toggle="collapse" data-target="#jobCollapse">Скрыть/показать работу</button>
            <div id="jobCollapse" class="collapse">
                <input type='radio' class='dynamic-radio' name='job_category' value='0'><label style="font-weight: bold;">Все категории</label>
                <?php
                require 'functions/print_dynamic_job.php';
                ?>
            </div>
            <div class="delimiter bg-dark"></div>
            <div class="title-small">ФИЛЬТРЫ</div>
            <div class="select-block">
                <div>ГОРОД</div>
                <select name="" id="city_id">
                    <?php
                        if($cities){
                            foreach ($cities as $city){
                                ?>
                                <option value="<?=$city['id']?>"><?=$city['title']?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="select-block">
                <div>ЗАРПЛАТА</div>
                <select name="" id="salary_id">
                    <?php
                    if($salarys){
                        foreach ($salarys as $salary){
                            ?>
                            <option value="<?=$salary['id']?>"><?=$salary['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="select-block">
                <div>ОПЫТ РАБОТЫ</div>
                <select name="" id="experience_id">
                    <?php
                    if($experiences){
                        foreach ($experiences as $experience){
                            ?>
                            <option value="<?=$experience['id']?>"><?=$experience['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="select-block">
                <div>РЕЖИМ РАБОТЫ</div>
                <select name="" id="employment_id">
                    <?php
                    if($employments){
                        foreach ($employments as $employment){
                            ?>
                            <option value="<?=$employment['id']?>"><?=$employment['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="delimiter bg-dark"></div>
            <button class="btn-2" style="width:100%; background-color: #E3973E;" onclick="filterResumes()">Обновить резюме</button>
        </div>
        <div class="col-2"></div>
        <div class="col-7">
            <div id='resumes'>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script>
    $( document ).ready(function() {
        //alert('Вывод в первый раз...');
        $.ajax({
            type: "POST",
            url: 'print_resumes.php',
            data:{city_id:0, salary_id:0, employment_id:0, education_id:0, search_company_name: false, search_text:''},
            success:function (data){
                $('#resumes').html(data);
            }
        });

    });

    function filterResumes(){
        search_employee_name= $("#search_employee_name").is(":checked") ? "true" : "false";//$("#checkboxId").is(":checked") ? "true" : "false";
        search_resume_name= $('#search_resume_name').is(":checked") ? "true" : "false";
        search_resume_descr= $('#search_resume_descr').is(":checked") ? "true" : "false";

        search_text= $('#search_text').val();

        city_id=$('#city_id').find(":selected").val();
        salary_id=$('#salary_id').find(":selected").val();
        experience_id=$('#experience_id').find(":selected").val();
        employment_id=$('#employment_id').find(":selected").val();
        job_category_id=$('input[name="job_category"]:checked').val();

        console.log(search_employee_name);
        console.log(search_text);

        $.ajax({
            type: "POST",
            url: 'print_resumes.php',
            data:{city_id:city_id, salary_id:salary_id, employment_id:employment_id, job_id:job_category_id
                ,search_employee_name: search_employee_name, search_resume_name: search_resume_name, search_resume_descr: search_resume_descr
                ,search_text:search_text},
            success:function (data){
                $('#resumes').html(data);
            }
        });



        /*
        * $( document ).ready(function() {
        //alert('Вывод в первый раз...');
        $.ajax({
            type: "POST",
            url: 'print_vacancies.php',
            data:{city_id:0, salary_id:0, employment_id:0, education_id:0, search_company_name: false, search_text:''},
            success:function (data){
                $('#vacancies').html(data);
            }
        });

    });
        * */
    }
</script>
</body>
</html>