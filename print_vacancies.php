<?php
require 'db_connect.php';
if(session_status()===PHP_SESSION_NONE)
{
    session_start();
}

?>
<?php

$city_id=(isset($_POST['city_id']))?$_POST['city_id']:0;
$salary_id=(isset($_POST['salary_id']))?$_POST['salary_id']:0;
$experience_id=(isset($_POST['experience_id']))?$_POST['experience_id']:0;
$employment_id=(isset($_POST['employment_id']))?$_POST['employment_id']:0;
$job_category_id=(isset($_POST['job_category_id']))?$_POST['job_category_id']:0;

$search_employer_name=(isset($_POST['search_employer_name']))?$_POST['search_employer_name']:'false';
$search_vacancy_name=(isset($_POST['search_vacancy_name']))?$_POST['search_vacancy_name']:'false';
$search_vacancy_descr=(isset($_POST['search_vacancy_descr']))?$_POST['search_vacancy_descr']:'false';

$search_text=(isset($_POST['search_text']))?$_POST['search_text']:'';

$sql="SELECT u.id as user_id,v.id,c.title as city, u.name as employer_name,v.description as description, jc.title as job_title, v.name as vacancy_title 
                    ,st.title as salary, emt.title as employment, ext.title as experience
                    ,SUBSTRING(v.description  , 1, 200) as description
            FROM vacancy v
            inner join city c on c.id=v.city_id
            inner join user u on u.id=v.user_id
            inner join job_category jc  on jc.id=v.job_category_id
            inner join salary_type st  on st.id=v.salary_type_id
            inner join employment_type emt  on emt.id=v.employment_type_id
            inner join experience_type ext on ext.id=v.experience_type_id
            where 1=1
            ";
$where_counter=0;
if($city_id!=0){
    //echo 'поиск город';
    $sql.=" and c.id=$city_id";
}
if($employment_id!=0){
    //echo 'поиск нанимательство';
    $sql.=" and emt.id=$employment_id";
}
if($experience_id!=0){
    //echo 'поиск опыт';
    $sql.=" and ext.id=$experience_id";
}
if($salary_id!=0){
    //echo 'поиск зарплата';
    $sql.=" and st.id=$salary_id";
}
if($job_category_id!=0){
    //echo 'поиск зарплата';
    $sql.=" and jc.id=$job_category_id";
}


if($search_text!=''){
    //echo 'ПОИСК ТЕКСТА';
    if($search_employer_name!='false'){
        //echo 'поиск имя';
        $sql.=" and u.name like '%$search_text%'";
    }
    if($search_vacancy_name!='false'){
        $sql.=" and  v.name like '%$search_text%'";
    }
    if($search_vacancy_descr!='false'){
        //echo 'поиск опсиание';
        $sql.=" and  v.description like '%$search_text%'";
    }
}

//var_dump($sql);

$vacancies=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
if(mysqli_num_rows($vacancies)==0){
    echo 'Кажется, по вашему запросу нет никаких вакансий...';
}
if($vacancies){
    foreach ($vacancies as $vacancy){
//        var_dump($resume);
        ?>
        <div class="main-card" style="border-bottom: 1px solid #E3973E">
            <div class="main-card-author" style="background-color: #E3973E;"><?=$vacancy['employer_name']?></div>
            <div class="main-card-brief">
                <div class="main-card-job-name title-small" style="color:#E3973E; margin-bottom: 0;"><?=$vacancy['vacancy_title']?></div>
                <div class="main-card-job-name" style="margin-bottom:20px;"><?=$vacancy['job_title']?></div>
                <div class="main-card-info">
                    <div class="info-row">
                        <div class="info-row-item" style="margin-left:0;"><?=$vacancy['city']?></div>
                        <div class="info-row-item"><?=$vacancy['salary']?></div>
                        <div class="info-row-item"><?=$vacancy['employment']?></div>
                        <div class="info-row-item"><?=$vacancy['experience']?></div>
                    </div>
                </div>
                <div class="main-card-descr"><?=$vacancy['description']?><?php echo(strlen($vacancy['description'])>200?('...'):''); ?></div>
                <div style="width:100%; display: flex; justify-content: end">
                    <a href="employer_vacancy.php?employer_id=<?=$vacancy['user_id']?>&vacancy_id=<?=$vacancy['id']?>">
                        <div class="text-with-icon">
                            <img class="text-with-icon-icon" src="img/icons/view_orange.svg" alt="">
                            <div class="text-with-icon-text" >Подробнее</div>
                        </div>
                    </>
                </div>
            </div>
        </div>
        <?php

    }
}
?>