<?php require '../db_connect.php'?>
<?php
$response['state']='fail';
$response['error']='';

if ( isset($_POST['skill_id'])) {
    $skill_id=$_POST['skill_id'];

    if(isset($_POST['vacancy_id'])){
        $vacancy_id=$_POST['vacancy_id'];

        $sql="delete from vacancy_skill where vacancy_id=$vacancy_id and skill_id=$skill_id";
        $skill=mysqli_query($link, $sql);

        if($skill){
            $response['state']='success';
        }
        else{
            $response['state']='fail';
            $response['error']='Ошибка в базе данных';
        }
    }

    if(isset($_POST['resume_id'])){
        $resume_id=$_POST['resume_id'];

        $sql="delete from resume_skill where resume_id=$resume_id and skill_id=$skill_id";
        $skill=mysqli_query($link, $sql);

        if($skill){
            $response['state']='success';
        }
        else{
            $response['state']='fail';
            $response['error']='Ошибка в базе данных';
        }
    }
}

echo json_encode($response);

?>

