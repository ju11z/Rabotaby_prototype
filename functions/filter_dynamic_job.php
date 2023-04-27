<?php
    require '../db_connect.php';
?>
<?php
if(isset($_POST['job_category_id'])){
    $job_category_id=$_POST['job_category_id'];
    $sql="select id, title from job_category where  id=$job_category_id";
    $result = mysqli_query($link, $sql) or die("database error:" . mysqli_error($link));
    $ids='(';
    foreach ($result as $entry){
        $ids.=$entry['id'].',';
    }
    $ids=substr($ids, 0, -1);
    $ids.=')';
    echo $ids;

    $sql="select id, name from vacancy where job_category_id in $ids";
    echo $sql;
    $vacancies = mysqli_query($link, $sql) or die("database error:" . mysqli_error($link));
    foreach ($vacancies as $vacancy){
        echo 'vacancy'." ".$vacancy['id']." ".$vacancy['name']."<br>";
    }

}
