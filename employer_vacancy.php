
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
    if(isset($_GET['employer_id']) && isset($_GET['vacancy_id'])){

        $employer_id=$_GET['employer_id'];
        $vacancy_id=$_GET['vacancy_id'];

        //$sql="select * from vacancy where id=$vacancy_id and user_id=$employer_id";
        $sql="select u.id as employer_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employer_id";
        $employer=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

        $sql="select * from vacancy v 
            inner join user u on u.id=v.user_id
            where v.id=$vacancy_id and user_id=$employer_id
    ";

        $vacancy=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));



        if(mysqli_num_rows($employer)==1 && mysqli_num_rows($vacancy)==1){
            $vacancy=mysqli_fetch_assoc($vacancy);
            $employer=mysqli_fetch_assoc($employer);
            //echo 'Есть такая вакансия!';
        }else{
            header('Location: '.'error.php');
            //echo 'Нет такой вакансии';
        }
    }
if(isset($_GET['employer_id']) && isset($_SESSION['user_id']) && $_SESSION['user_id']==$_GET['employer_id']){
    //echo 'второй вариант';
    $employer_id=$_GET['employer_id'];
    $sql="select u.id as employer_id, u.name as user_name, u.phone as user_phone, u.email as user_email, u.about as user_about,u.user_type_id from user u where u.id=$employer_id";
    $employer=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
    if(mysqli_num_rows($employer)==1){
        $employer=mysqli_fetch_assoc($employer);
        //echo 'Есть такая вакансия!';
    }

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
                <div id="vacancy">
                    <?php

                        if($_SESSION['user_id']==$_GET['employer_id'] && !(isset($_GET['vacancy_id']))){
                            echo 'Пожалуйста, выберите в профиле справа вакансию, которую хотите редактировать, или же создайте новую.';
                        }
                        else{

                            require 'vacancy.php';
                        }

                    ?>
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col-3" style="background-color: #E3973E;">

                    <div class="row pt-5 pb-5 f-light" >
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div id="employer">
                                <?php

                                require 'employer.php';
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
            //alert('алееее');
        }
        function editEmployer(){

            //alert('Редактирование информации о компании!');
            $.ajax({
                type:"GET",
                url: "edit_employer.php",
                data:{employer_id:<?= $employer_id ?>},
                success:function (response){
                    $("#employer").html(response);

                }
            })
        }

        function viewEmployer(employer_id){
            //console.log(13);
            //alert('Просмотр работодателя');
            $.ajax({
                type:"GET",
                url: "employer.php",
                data:{employer_id:employer_id},
                success:function (response){
                    $("#employer").html(response);
                }
            });
        }

        function updateProfileImage(){
            var file_data = $('#profileImg').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);

            //alert(form_data);
            console.log(form_data);


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

        function trySaveEmployer(){
            //alert('Попытка сохранить работника...');

            //alert($('#edit_company_name=').val());

            //please_test_me=$('#pleaseTestMe=').val();
            //alert(please_test_me);
            edit_company_name=$('#edit_company_name').val();
            edit_company_about=$('#edit_company_about').val();
            edit_company_phone=$('#edit_company_phone').val();
            edit_company_email=$('#edit_company_email').val();

            console.log(edit_company_name, edit_company_email);

            $.ajax({
                type:"POST",
                url: "functions/validate_employer.php",
                data:{company_name:edit_company_name, company_about:edit_company_about, company_phone:edit_company_phone, company_email:edit_company_email},
                success:function (response){
                    response=JSON.parse(response);
                    if(response.state=='success'){
                        //alert('Аякс на сохранение');

                        $.ajax({
                            type:"POST",
                            url: "functions/save_employer.php",
                            data:{employer_id:<?=$employer_id?>, company_name:edit_company_name, company_about: edit_company_about, company_phone: edit_company_phone, company_email: edit_company_email},
                            success:function (response){
                                //alert('Успех сохранения');
                                viewEmployer(<?=$employer_id?>);
                            }
                        });

                    }
                    else{
                        //alert(response.name_error);
                        //alert(response.descr_error);
                        $("#name_error").html(response.name_error);
                        $("#about_error").html(response.about_error);
                        $("#phone_error").html(response.phone_error);
                        $("#email_error").html(response.email_error);
                    }
                }
            });

            updateProfileImage();

        }

        function viewEmployer(employer_id) {
            //alert('Просмотр работодателя');
            console.log(13);
            //alert('Просмотр вакансии');
            $.ajax({
                type: "GET",
                url: "employer.php",
                data: {employer_id: employer_id},
                success: function (response) {

                    $("#employer").html(response);

                }
            });
        }

        function trySaveVacancy(vacancy_id){
            edit_vacancy_name=$('#edit_vacancy_name').val();
            edit_vacancy_descr=$('#edit_vacancy_descr').val();
            edit_vacancy_city=$('#edit_vacancy_city').val();
            edit_vacancy_experience=$('#edit_vacancy_experience').val();
            edit_vacancy_employment=$('#edit_vacancy_employment').val();
            edit_vacancy_salary=$('#edit_vacancy_salary').val();
            edit_vacancy_job=$('#edit_vacancy_job').val();
            console.log(edit_vacancy_name, edit_vacancy_descr);

            $.ajax({
                type:"POST",
                url: "functions/validate_vacancy.php",
                data:{vacancy_name:edit_vacancy_name, vacancy_descr:edit_vacancy_descr},
                success:function (response){
                    response=JSON.parse(response);
                    if(response.state=='success'){
                        //alert('Аякс на сохранение');

                        $.ajax({
                            type:"POST",
                            url: "save_vacancy.php",
                            data:{vacancy_id:vacancy_id, vacancy_name:edit_vacancy_name, vacancy_descr:edit_vacancy_descr,
                                vacancy_city:edit_vacancy_city, vacancy_salary:edit_vacancy_salary, vacancy_employment:edit_vacancy_employment,vacancy_job:edit_vacancy_job,
                                vacancy_experience:edit_vacancy_experience},
                            success:function (response){
                                //alert('Успех сохранения');
                                viewVacancy(vacancy_id);
                                viewEmployer(<?=$employer_id?>);

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

        function editVacancy(vacancy_id){

            //alert('Редактирование вакансии');
            $.ajax({
                type:"GET",
                url: "edit_vacancy.php",
                data:{vacancy_id:vacancy_id},
                success:function (response){

                    $("#vacancy").html(response);

                }
            })
        }

        function tryAddVacancy(){
            //alert('Добавление вакансии...');
            add_vacancy_name=$('#add_vacancy_name').val();
            add_vacancy_descr=$('#add_vacancy_descr').val();
            add_vacancy_city=$('#add_vacancy_city').val();
            add_vacancy_experience=$('#add_vacancy_experience').val();
            add_vacancy_employment=$('#add_vacancy_employment').val();
            add_vacancy_salary=$('#add_vacancy_salary').val();
            add_vacancy_job=$('#add_vacancy_job').val();

            $.ajax({
                type:"POST",
                url: "functions/validate_vacancy.php",
                data:{vacancy_name:add_vacancy_name, vacancy_descr:add_vacancy_descr},
                success:function (response){
                    response=JSON.parse(response);
                    if(response.state=='success'){
                        //alert('Аякс на добавление');

                        $.ajax({
                            type:"POST",
                            url: "functions/add_vacancy.php",
                            data:{vacancy_name:add_vacancy_name, vacancy_descr:add_vacancy_descr,
                                vacancy_city:add_vacancy_city, vacancy_salary:add_vacancy_salary, vacancy_employment:add_vacancy_employment, vacancy_job:add_vacancy_job,
                                vacancy_experience:add_vacancy_experience},
                            success:function (response_1){
                                response_1=JSON.parse(response_1);
                                if(response_1.state=='success'){
                                    //alert('Успех добавления!');
                                    vacancy_id=response_1.new_vacancy_id;
                                    console.log(vacancy_id);
                                    viewEmployer(<?=$_SESSION['user_id']?>);
                                    viewVacancy(vacancy_id);
                                }

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



            //alert(add_vacancy_city);


        }

        function createVacancy(){
            $.ajax({
                type:"GET",
                url: "create_vacancy.php",
                data:{employer_id:<?=$employer_id?>},
                success:function (response){

                    $("#vacancy").html(response);

                }
            })
        }



       /*

        */

        function viewVacancy(vacancy_id){
            //console.log(13);
            //alert('Просмотр вакансии');
            $.ajax({
                type:"GET",
                url: "vacancy.php",
                data:{vacancy_id:vacancy_id},
                success:function (response){

                    $("#vacancy").html(response);

                }
            });
        }
    </script>
</body>
</html>