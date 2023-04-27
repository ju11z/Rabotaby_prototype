<?php
require '..\db_connect.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response['state']='fail';

    $job_category_id=1;

    if(isset($_POST['vacancy_name']) && isset($_POST['vacancy_descr']) && isset($_POST['vacancy_city']) && isset($_POST['vacancy_salary']) && isset($_POST['vacancy_employment']) && isset($_POST['vacancy_experience']) && isset($_POST['vacancy_job'])){
        $user_id=$_SESSION['user_id'];
        $vacancy_name=$_POST['vacancy_name'];
        $vacancy_descr=$_POST['vacancy_descr'];
        $vacancy_city=$_POST['vacancy_city'];
        $vacancy_salary=$_POST['vacancy_salary'];
        $vacancy_employment=$_POST['vacancy_employment'];
        $vacancy_experience=$_POST['vacancy_experience'];
        $vacancy_job=$_POST['vacancy_job'];

        $sql="insert into vacancy (user_id, name, description, city_id, salary_type_id, employment_type_id, experience_type_id,job_category_id) values ($user_id,'$vacancy_name','$vacancy_descr',$vacancy_city,$vacancy_salary, $vacancy_employment, $vacancy_experience, $vacancy_job)";
        $res=mysqli_query($link, $sql);
        if($res){
            $id=mysqli_insert_id($link);
            $response['new_vacancy_id']=$id;
            $response['state']='success';
        }

    }

    echo json_encode($response);




