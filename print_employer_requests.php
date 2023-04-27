<?php
require 'db_connect.php';
session_start();

?>
<?php

if(isset($_POST['vacancy_id']) && isset($_POST['request_type_id']) && isset($_POST['request_status_id']) && isset($_POST['date_sort'])){
    $user_id=$_SESSION['user_id'];

    $vacancy_id=$_POST['vacancy_id'];
    $request_type_id=$_POST['request_type_id'];
    $request_status_id=$_POST['request_status_id'];
    $date_sort=$_POST['date_sort'];
    ///работодатель : все резюме, на которые я отправляла реквест или все резюме на одну из моих вакансий
    $sql="SELECT u.id as user_id,r.id,c.title as city, u.name as employer_name,r.description as description, jc.title as job_title, 
                    et.title as education, st.title as salary, emt.title as employment, ext.title as experience, 
                    SUBSTRING(r.description  , 1, 300) as description,
                    rt.title as request_type, rs.title as request_status,
                    req.date_sent as date_sent, req.date_responded as date_responded
                    
            FROM resume r
            inner join city c on c.id=r.city_id
            inner join user u on u.id=r.user_id
            inner join job_category jc  on jc.id=r.job_category_id
            inner join education_type et  on et.id=r.education_type_id
            inner join salary_type st  on st.id=r.salary_type_id
            inner join employment_type emt  on emt.id=r.employment_type_id
            inner join experience_type ext on ext.id=r.experience_type_id
            inner join request req on req.resume_id=r.id
            inner join vacancy v on v.id=req.vacancy_id
            
              inner join request_type rt on rt.id=req.request_type_id
            inner join request_status rs on rs.id=req.request_status_id
            where v.user_id=$user_id
            ";

    if($request_type_id==1){
        echo '<h2>request_type_id = 1</h2>';
        $sql="
            inner join request req on on req.resume_id=r.id
            inner join vacancy v on v.id=req.vacancy_id
            where v.user_id=$user_id 
        ";
    }
    if($request_type_id==2){
        echo '<h2>request_type_id = 2</h2>';
    }



    if($request_status_id!=0){
        echo 'поиск город';
        $sql.=" and c.id=$city_id";
    }
}

$city_id=(isset($_POST['city_id']))?$_POST['city_id']:0;
$salary_id=(isset($_POST['salary_id']))?$_POST['salary_id']:0;
$experience_id=(isset($_POST['experience_id']))?$_POST['experience_id']:0;
$employment_id=(isset($_POST['employment_id']))?$_POST['employment_id']:0;

$search_employee_name=(isset($_POST['search_employee_name']))?$_POST['search_employee_name']:'false';
$search_resume_name=(isset($_POST['search_resume_name']))?$_POST['search_resume_name']:'false';
$search_resume_descr=(isset($_POST['search_resume_descr']))?$_POST['search_resume_descr']:'false';

$search_text=(isset($_POST['search_text']))?$_POST['search_text']:'';

$sql="SELECT u.id as user_id,r.id,c.title as city, u.name as employer_name,r.description as description, jc.title as job_title, 
                    et.title as education, st.title as salary, emt.title as employment, ext.title as experience, 
                    SUBSTRING(r.description  , 1, 300) as description
            FROM resume r 
            inner join city c on c.id=r.city_id
            inner join user u on u.id=r.user_id
            inner join job_category jc  on jc.id=r.job_category_id
            inner join education_type et  on et.id=r.education_type_id
            inner join salary_type st  on st.id=r.salary_type_id
            inner join employment_type emt  on emt.id=r.employment_type_id
            inner join experience_type ext on ext.id=r.experience_type_id 
            where 1=1
            ";
$where_counter=0;
if($city_id!=0){
    echo 'поиск город';
    $sql.=" and c.id=$city_id";
}
if($employment_id!=0){
    echo 'поиск нанимательство';
    $sql.=" and et.id=$employment_id";
}
if($experience_id!=0){
    echo 'поиск опыт';
    $sql.=" and ext.id=$experience_id";
}
if($salary_id!=0){
    echo 'поиск зарплата';
    $sql.=" and st.id=$salary_id";
}

echo $search_employee_name;
echo $search_resume_descr;

if($search_text!=''){
    echo 'ПОИСК ТЕКСТА';
    if($search_employee_name!='false'){
        echo 'поиск имя';
        $sql.=" and u.name like '%$search_text%'";
    }
//    if($search_resume_name==true){
//        $sql.=" where  v.name like '%$search_text%'";
//    }
    if($search_resume_descr!='false'){
        echo 'поиск опсиание';
        $sql.=" and  r.description like '%$search_text%'";
    }
}

var_dump($sql);

$resumes=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
if(mysqli_num_rows($resumes)==0){
    echo 'Кажется, по вашему запросу нет никаких резюме...';
}
if($resumes){
    foreach ($resumes as $resume){
//        var_dump($resume);
        ?>
        <div class="main-card">
            <div class="main-card-author" style="background-color: #7D1527;"><?=$resume['employer_name']?></div>
            <div class="main-card-brief">
                <div class="main-card-job-name title-small" style="color:#7D1527;"><?=$resume['job_title']?></div>
                <div class="main-card-info">
                    <div class="info-row">
                        <div class="info-row-item" style="margin-left:0;"><?=$resume['city']?></div>
                        <div class="info-row-item"><?=$resume['salary']?></div>
                        <div class="info-row-item"><?=$resume['employment']?></div>
                        <div class="info-row-item"><?=$resume['experience']?></div>
                    </div>
                </div>
                <div class="main-card-descr"><?=$resume['description']?></div>
                <div style="width:100%; display: flex; justify-content: end">
                    <a href="employee_resume.php?employee_id=<?=$resume['user_id']?>&resume_id=<?=$resume['id']?>">
                        <div class="text-with-icon">
                            <img class="text-with-icon-icon" src="img/icons/view.svg" alt="">
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