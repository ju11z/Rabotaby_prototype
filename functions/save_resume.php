<?php
require '../db_connect.php';
?>

<?php


if(isset($_POST['resume_id'])){
    $resume_id=$_POST['resume_id'];

    if(isset($_POST['resume_name'])){
        $resume_name=$_POST['resume_name'];
        $sql="update resume set name='$resume_name' where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_descr'])){
        $resume_descr=$_POST['resume_descr'];
        $sql="update resume set description='$resume_descr' where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_city'])){
        $resume_city=$_POST['resume_city'];
        $sql="update resume set city_id=$resume_city where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_salary'])){
        $resume_salary=$_POST['resume_salary'];
        $sql="update resume set salary_type_id=$resume_salary where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_employment'])){
        $resume_employment=$_POST['resume_employment'];
        $sql="update resume set employment_type_id=$resume_employment where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_experience'])){
        echo 'есть опыт';
        $resume_experience=$_POST['resume_experience'];
        echo $resume_experience;
        $sql="update resume set experience_type_id=$resume_experience where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['resume_job'])){
        $resume_job=$_POST['resume_job'];
        $sql="update resume set job_category_id=$resume_job where id=$resume_id";
        $res=mysqli_query($link, $sql);
    }

}
