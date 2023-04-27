<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==2){
    $uid=$_SESSION['user_id'];
    ?>
        <div class="container">
            <div class="row">
                <div class="col-12" style="background-color: #E3973E;">
                    <div class="menu-wrapper" style="background-color: #E3973E; color:white;">
                        <div class="menu-item menu-logo"><img src="img/logo.svg"></div>
                        <div class="menu-item" style="margin-right: auto;">Работодатель</div>
                        <div class="menu-item"><a href="search_resume.php" style="margin-right: auto;">Искать работников</a></div>
                        <div class="menu-item"><a href="requests.php" style="margin-right: auto;">Отклики</a></div>
                        <div class="menu-item"><a href="employer_vacancy.php?employer_id=<?=$uid?>" style="margin-right: auto;">Мои вакансии</a></div>
                        <div class="menu-item"><button onclick="logout()" style="margin-right: 20px;">Выйти</button></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
if(isset($_SESSION['user_type_id']) && $_SESSION['user_type_id']==1){
    $uid=$_SESSION['user_id'];
    $resume_id=$_SESSION['resume_id'];
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12" style="background-color: #7D1527;">
                <div class="menu-wrapper" style="background-color: #7D1527; color:white;">
                    <div class="menu-item menu-logo"><img src="img/logo.svg"></div>
                    <div class="menu-item" style="margin-right: auto;">Работник</div>
                    <div class="menu-item"><a href="search_vacancy.php" style="margin-right: auto;">Искать работу</a></div>
                    <div class="menu-item"><a href="requests.php" style="margin-right: auto;">Отклики</a></div>
                    <div class="menu-item"><a href="employee_resume.php?employee_id=<?=$uid?>&resume_id=<?=$resume_id?>" style="margin-right: auto;">Мое резюме</a></div>
                    <div class="menu-item"><button onclick="logout()" style="margin-right: 20px;">Выйти</button></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script src="js/jquery.js"></script>
<script>
    function logout(){
        $.ajax({
            type:"POST",
            url: "functions/logout.php",
            data:{},
            success:function (response){
                response=JSON.parse(response);
                if(response.state=='success'){
                    alert('Вы вышли');
                    window.location.replace("sign_in.php");
                }else{

                }

            }
        });
    }
</script>
