<?php
    require 'db_connect.php';
?>
<?php
if(isset($_POST['vacancy_id'])){
    $vacancy_id=$_POST['vacancy_id'];

    if(isset($_POST['vacancy_name'])){
        $vacancy_name=$_POST['vacancy_name'];
        $sql="update vacancy set name='$vacancy_name' where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_descr'])){
        $vacancy_descr=$_POST['vacancy_descr'];
        $sql="update vacancy set description='$vacancy_descr' where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_city'])){
        $vacancy_city=$_POST['vacancy_city'];
        $sql="update vacancy set city_id=$vacancy_city where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_salary'])){
        $vacancy_salary=$_POST['vacancy_salary'];
        $sql="update vacancy set salary_type_id=$vacancy_salary where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_employment'])){
        $vacancy_employment=$_POST['vacancy_employment'];
        $sql="update vacancy set employment_type_id=$vacancy_employment where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_experience'])){
        $vacancy_experience=$_POST['vacancy_experience'];
        $sql="update vacancy set experience_type_id=$vacancy_experience where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

    if(isset($_POST['vacancy_job'])){
        $vacancy_job=$_POST['vacancy_job'];
        $sql="update vacancy set job_category_id=$vacancy_job where id=$vacancy_id";
        $res=mysqli_query($link, $sql);
    }

}
