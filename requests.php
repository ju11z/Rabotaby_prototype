<?php
require 'db_connect.php';
?>
<?php
require 'menu.php';
?>
<?php

$sql="select * from request_type";
$request_types=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

$sql="select * from request_status";
$request_statuses=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));




?>

<!doctype html>
<html lang="en">
<link>
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
    <div class="row pt-5">
        <div class="col-3">
            <div class="title-small">ФИЛЬТРЫ</div>
            <div class="select-block">
                <div>ТИП ЗАЯВОК</div>
                <select name="" id="request_type_id">
                    <?php
                    if($request_types){
                        foreach ($request_types as $request_type){
                            ?>
                            <option value="<?=$request_type['id']?>"><?=$request_type['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="select-block">
                <div>СТАТУС ЗАЯВОК</div>

                <select name="" id="request_status_id">
                    <option value="0">Все статусы</option>
                    <?php
                    if($request_statuses){
                        foreach ($request_statuses as $request_status){
                            ?>
                            <option value="<?=$request_status['id']?>"><?=$request_status['title']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="delimiter bg-dark"></div>
            <?php
                if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==2){
                    echo "<div class='select-block'><div>ВАКАНСИЯ</div>";
                    $user_id=$_SESSION['user_id'];
                    $sql="select * from vacancy where user_id=$user_id";
                    $vacancies_list=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));

                    if($vacancies_list){

                        echo "<select id='vacancy_id'>";
                        echo "<option value='0'>"."Все вакансии"."</option>";
                        foreach ($vacancies_list as $vacancy){
                            echo "<option value='".$vacancy['id']."'>".$vacancy['name']."</option>";
                        }
                        echo '</select>';
                    }
                    else{
                        echo 'У вас еще нет вакансий, по которым можно произвести фильтрацию.';
                    }
                    echo "</div>";
                    echo " <div class='delimiter bg-dark'></div>";
                }
            ?>
            <div class="title-small">СОРТИРОВАТЬ ПО ДАТЕ</div>
                <select name="" id="date_sort">
                    <option value="0">В любом порядке</option>
                    <option value="1">по дате отправления(по возрастанию)</option>
                    <option value="2">по дате отправления(по убыванию)</option>
                    <option value="3">по дате ответа(по возрастания)</option>
                    <option value="4">по дате ответа(по убыванию)</option>
                </select>
            <div class="delimiter bg-dark"></div>
            <?php
                if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==1){
                    ?>
                    <button class="btn-2" style="width:100%; background-color: #7D1527;" onclick="filterRequests()">Обновить заявки</button>
                    <?php
                }
            ?>
            <?php
            if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==2){
                ?>
                <button class="btn-2" style="width:100%; background-color: #E3973E;" onclick="filterRequests()">Обновить заявки</button>
                <?php
            }
            ?>

        </div>
        <div class="col-2"></div>
        <div class="col-7">
            <div id='requests' >
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script>
    $( document ).ready(function() {
        //$("#request_type_id").val(2);
        $("#request_type_id option[value=1]").attr('selected', 'selected');

        request_type_id=$('#request_type_id').find(":selected").val();
        request_status_id=$('#request_status_id').find(":selected").val();
        vacancy_id=$('#vacancy_id').find(":selected").val();
        date_sort=$('#date_sort').find(":selected").val();

        console.log(request_type_id, request_status_id, vacancy_id, date_sort);

        //alert('Вывод в первый раз...');
        $.ajax({
            type: "POST",
            url: 'print_requests.php',
            data:{request_type_id:request_type_id, request_status_id:request_status_id, vacancy_id:vacancy_id ,date_sort:date_sort},
            success:function (data){
                $('#requests').html(data);
            }
        });

    });

    function updateRequest(request_id, request_status_id){
        $.ajax({
            type: "POST",
            url: 'functions/update_request.php',
            data:{request_id:request_id, request_status_id:request_status_id},
            success:function (data){
                //alert('sent smth');
                filterRequests();
                //$('#requests').html(data);
            }
        });
    }

    function filterRequests(){
        //alert('filter requests');
        request_type_id=$('#request_type_id').find(":selected").val();
        request_status_id=$('#request_status_id').find(":selected").val();
        vacancy_id=$('#vacancy_id').find(":selected").val();
        date_sort=$('#date_sort').find(":selected").val();

        console.log(request_type_id, request_status_id,date_sort, vacancy_id);

        $.ajax({
            type: "POST",
            url: 'print_requests.php',
            data:{request_type_id:request_type_id, request_status_id:request_status_id, vacancy_id:vacancy_id,date_sort:date_sort},
            success:function (data){
                //alert('sent smth');
                $('#requests').html(data);
            }
        });

    }
</script>
</body>
</html>