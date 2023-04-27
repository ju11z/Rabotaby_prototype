
<?php
require 'db_connect.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
require 'menu.php';
?>
<?php
if(isset($_GET['employee_id']) && isset($_GET['resume_id'])){

    $employee_id=$_GET['employee_id'];
    $resume_id=$_GET['resume_id'];

    //$sql="select * from vacancy where id=$vacancy_id and user_id=$employer_id";
    $sql="select u.id as employer_id, u.name as user_name, 
       u.phone as user_phone, u.email as user_email, 
       u.about as user_about,u.user_type_id 
    from user u where u.id=$employee_id";

    $employee=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

    $sql="select * from resume r 
            inner join user u on u.id=r.user_id
            where r.id=$resume_id and user_id=$employee_id
    ";

    $resume=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));



    if(mysqli_num_rows($employee)==1 && mysqli_num_rows($resume)==1){
        $resume=mysqli_fetch_assoc($resume);
        $employee=mysqli_fetch_assoc($employee);
        //echo 'Есть такая вакансия!';
    }else{
        header('Location: '.'error.php');
        //echo 'Нет такой вакансии';
    }
}
if(isset($_GET['employee_id']) && isset($_SESSION['user_id']) && $_SESSION['user_id']==$_GET['employee_id']){
    $employee_id=$_GET['employee_id'];
    /*
    $sql="select u.id as employer_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employer_id";
    $employer=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
    if(mysqli_num_rows($employer)==1){
        $employer=mysqli_fetch_assoc($employer);
        //echo 'Есть такая вакансия!';
    }
    */

}


?>
<!doctype html>
<html lang="en">
<head>
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
    <div class="row">
        <div class="col-7 mt-5 mb-5">
            <div id="resume">
                <?php
                    require 'resume.php';


                ?>
            </div>
        </div>
        <div class="col-2"></div>
        <div class="col-3" style="background-color: #7D1527;">
            <div class="row pt-5 pb-5 f-light">
                <div class="col-1"></div>
                <div class="col-10">
                    <div id="employee">
                        <?php
                        require 'employee.php';
                        ?>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script>
    function printStmh(){
        //please_test_me=$('#pleaseTestMe=').val();
        //alert(please_test_me);
        //alert("ебляяя");
        smth=$("input[name=smthhh]").val();
        smth=$('#blya').val();
        //alert(smth);
    }
    function editEmployee(){

        //alert('Редактирование информации о компании!');
        $.ajax({
            type:"GET",
            url: "edit_employee.php",
            data:{employee_id:<?= $employee_id ?>},
            success:function (response){
                $("#employee").html(response);
            }
        })
    }

    function viewEmployee(employee_id){
        console.log(13);
        //alert('Просмотр работодателя');
        $.ajax({
            type:"GET",
            url: "employee.php",
            data:{employee_id:employee_id},
            success:function (response){
                $("#employee").html(response);
            }
        });
    }

    function updateProfileImage(){
        var file_data = $('#profileImg').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        //alert(form_data);
        //console.log(form_data);


        $.ajax({
            url: 'functions/change_profile_img.php', // <-- point to server-side PHP script
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
                //alert(php_script_response); // <-- display response from the PHP script, if any
                console.log()
            }
        });

    }

    function trySaveEmployee(){
        //alert('Попытка сохранить работника...');

        //alert($('#edit_company_name=').val());

        //please_test_me=$('#pleaseTestMe=').val();
        //alert(please_test_me);
        edit_employee_name=$('#edit_employee_name').val();
        edit_employee_about=$('#edit_employee_about').val();
        edit_employee_phone=$('#edit_employee_phone').val();
        edit_employee_email=$('#edit_employee_email').val();

        console.log(edit_employee_name, edit_employee_email);

        $.ajax({
            type:"POST",
            url: "functions/validate_employee.php",
            data:{employee_name:edit_employee_name, employee_about:edit_employee_about, employee_phone:edit_employee_phone, employee_email:edit_employee_email},
            success:function (response){
                response=JSON.parse(response);
                if(response.state=='success'){
                    //alert('Аякс на сохранение');

                    $.ajax({
                        type:"POST",
                        url: "functions/save_employee.php",
                        data:{employee_id:<?=$employee_id?>, employee_name:edit_employee_name, employee_about: edit_employee_about, employee_phone: edit_employee_phone, employee_email: edit_employee_email},
                        success:function (response){
                            //alert('Успех сохранения');
                            viewEmployee(<?=$employee_id?>);
                        }
                    });

                }
                else{
                    //alert(response.name_error);
                    //alert(response.descr_error);
                    $("#employee_name_error").html(response.name_error);
                    $("#about_error").html(response.about_error);
                    $("#phone_error").html(response.phone_error);
                    $("#email_error").html(response.email_error);
                }
            }
        });

        //alert('дошло');
        updateProfileImage();

    }

    function saveEmployee(employer_id){
        //edit_vacancy_name=$('#edit_vacancy_name').val();
        //alert('Сохранение вакансии');
        $.ajax({
            type:"GET",
            url: "save_vacancy.php",
            data:{vacancy_id:vacancy_id},
            success:function (response){
                //alert('Успех сохранения');
                viewVacancy(vacancy_id);
            }
        });
        //alert('Сохранение информации о компании!');
    }

    function viewEmployee(employee_id) {
        console.log(13);
        //alert('Просмотр вакансии');
        $.ajax({
            type: "GET",
            url: "employee.php",
            data: {employee_id: employee_id},
            success: function (response) {

                $("#employee").html(response);

            }
        });
    }



    function trySaveResume(resume_id){
        edit_resume_name=$('#edit_resume_name').val();
        edit_resume_descr=$('#edit_resume_descr').val();
        edit_resume_city=$('#edit_resume_city').val();
        edit_resume_experience=$('#edit_resume_experience').val();
        edit_resume_employment=$('#edit_resume_employment').val();
        edit_resume_salary=$('#edit_resume_salary').val();
        edit_resume_job=$('#edit_resume_job').val();
        console.log(edit_resume_experience);

        $.ajax({
            type:"POST",
            url: "functions/validate_resume.php",
            data:{resume_name:edit_resume_name, resume_descr:edit_resume_descr},
            success:function (response){
                response=JSON.parse(response);
                if(response.state=='success'){
                    //alert('Аякс на сохранение');

                    $.ajax({
                        type:"POST",
                        url: "functions/save_resume.php",
                        data:{resume_id:resume_id, resume_name:edit_resume_name, resume_descr:edit_resume_descr,
                            resume_city:edit_resume_city, resume_salary:edit_resume_salary, resume_employment:edit_resume_employment,
                            resume_experience:edit_resume_experience, resume_job:edit_resume_job},
                        success:function (response){
                            //alert('Успех сохранения');
                            viewResume(resume_id);
                        }
                    });

                }
                else{
                    //alert(response.name_error);
                    //alert(response.descr_error);
                    $("#name_error").html(response.name_error);
                    $("#descr_error").html(response.descr_error);
                }
            }
        });

    }

    function editResume(resume_id){

        //alert('Редактирование резюме');
        $.ajax({
            type:"GET",
            url: "edit_resume.php",
            data:{resume_id:resume_id},
            success:function (response){

                $("#resume").html(response);

            }
        })
    }

    function viewResume(employee_id,resume_id){
        employee_id=<?=$employee_id?>;
        console.log(13);
        //alert('Просмотр вакансии');
        $.ajax({
            type:"GET",
            url: "resume.php",
            data:{employee_id:employee_id,resume_id:resume_id},
            success:function (response){

                $("#resume").html(response);

            }
        });
    }
</script>
</body>
</html>