<?php require '../db_connect.php'?>
<?php
$response['state']='fail';
$response['error']='';

if ( isset($_POST['skill_id'])) {
    $skill_id=$_POST['skill_id'];

    if(isset($_POST['vacancy_id'])){
        $vacancy_id=$_POST['vacancy_id'];

        $sql="select * from vacancy_skill where vacancy_id=$vacancy_id and skill_id=$skill_id";
        $skill=mysqli_query($link, $sql);

        if(mysqli_num_rows($skill)>0){
            $response['state']='fail';
            $response['error']='У вас уже добавлен этот навык!';
        }
        else{
            $sql="insert into vacancy_skill (vacancy_id, skill_id) values ( $vacancy_id, $skill_id)";
            $result = mysqli_query($link, $sql);

            if($result){
                $response['state']='success';
            }
            else{
                $response['state']='fail';
                $response['error']='Ошибка в базе данных';
            }
        }
    }
    if(isset($_POST['resume_id'])){
        $resume_id=$_POST['resume_id'];

        $sql="select * from resume_skill where resume_id=$resume_id and skill_id=$skill_id";
        $skill=mysqli_query($link, $sql);

        if(mysqli_num_rows($skill)>0){
            $response['state']='fail';
            $response['error']='У вас уже добавлен этот навык!';
        }
        else{
            $sql="insert into resume_skill (resume_id, skill_id) values ( $resume_id, $skill_id)";
            $result = mysqli_query($link, $sql);

            if($result){
                $response['state']='success';
            }
            else{
                $response['state']='fail';
                $response['error']='Ошибка в базе данных';
            }
        }
    }
}

echo json_encode($response);

?>

