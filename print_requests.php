<?php
require 'db_connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
if(isset($_POST['request_type_id']) && isset($_POST['request_status_id']) && isset($_POST['date_sort'])){

    $request_type_id=$_POST['request_type_id'];
    $request_status_id=$_POST['request_status_id'];
    $date_sort=$_POST['date_sort'];

if(isset($_SESSION['user_type_id'])){
    $user_type_id=$_SESSION['user_type_id'];
    if($user_type_id==1){
        $resume_id=$_SESSION['resume_id'];
        $sql="SELECT u.id as user_id,v.id,v.name as vacancy_title,c.title as city, u.name as employer_name,v.description as description, jc.title as job_title, 
                    st.title as salary, emt.title as employment, ext.title as experience,
                    req.id as request_id, rt.id as req_type, rs.id as req_status,
                    req.date_sent as date_sent, req.date_responded as date_responded,
                    req.resume_id, req.vacancy_id,
                    SUBSTRING(v.description, 1, 300) as description
            FROM vacancy v
            inner join city c on c.id=v.city_id
            inner join user u on u.id=v.user_id
            inner join job_category jc  on jc.id=v.job_category_id
            inner join salary_type st  on st.id=v.salary_type_id
            inner join employment_type emt  on emt.id=v.employment_type_id
            inner join experience_type ext on ext.id=v.experience_type_id
            inner join request req on req.vacancy_id=v.id

            inner join request_type rt on rt.id=req.request_type_id
            inner join request_status rs on rs.id=req.request_status_id
            where req.resume_id=$resume_id
            ";

        if($request_status_id!=0){
            $sql.=" and rs.id=$request_status_id";
        }

        if($request_type_id!=0){
            $sql.=" and rt.id=$request_type_id ";
        }
        /*
         <option value="0">В любом порядке</option>
                    <option value="1">по дате отправления(по возрастанию)</option>
                    <option value="2">по дате отправления(по убыванию)</option>
                    <option value="3">по дате ответа(по возрастания)</option>
                    <option value="4">по дате ответа(по убыванию)</option>*/

        if($date_sort==1){
            $sql.="order by date_sent asc";
        }
        if($date_sort==2){
            $sql.="order by date_sent desc";
        }
        if($date_sort==3 && $request_type_id!=1){
            $sql.="order by date_responded asc";
        }
        if($date_sort==4 && $request_type_id!=1){
            $sql.="order by date_responded desc";
        }


        //echo $sql;



        $requests=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
        if($requests){
            foreach ($requests as $request){
                //echo 'реквест';
                ?>
                <div class="main-card" style="border-bottom: 1px solid #E3973E">
                    <div class="main-card-author" style="background-color: #E3973E;"><?=$request['employer_name']?></div>
                    <div class="main-card-brief">
                        <div class="main-card-job-name title-small" style="color:#E3973E; margin-bottom: 0"><?=$request['vacancy_title']?></div>
                        <div class="main-card-job-name" style="margin-bottom: 20px;"><?=$request['job_title']?></div>
                        <div class="main-card-info">
                            <div class="info-row">
                                <div class="info-row-item" style="margin-left:0;"><?=$request['city']?></div>
                                <div class="info-row-item"><?=$request['salary']?></div>
                                <div class="info-row-item"><?=$request['employment']?></div>
                                <div class="info-row-item"><?=$request['experience']?></div>
                            </div>
                        </div>
                        <div class="main-card-descr"><?=$request['description']?></div>
                        <div class="main-card-date">
                            <?php
                                if($request['date_sent']!=null){
                                    ?>
                                    <div class="main-card-date-item">
                                        <div>Дата отправки</div>
                                        <div><?=$request['date_sent']?></div>
                                    </div>
                                    <?php
                                }
                            ?>
                            <?php
                            if($request['date_responded']!=null){
                                ?>
                            <div class="main-card-date-item">
                                <div>Дата ответа</div>
                                <div><?=$request['date_responded']?></div>
                            </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div style="width:100%; display: flex; justify-content: end; flex-direction: row; padding-left:20px;">
                            <?php
                                if($request['req_status']==1 && $request['req_type']==2){
                                    ?>
                                    <button onclick="updateRequest(<?=$request['request_id']?>,2)" style="padding-right:20px;">
                                        <div class="text-with-icon">
                                            <img class="text-with-icon-icon" src="img/icons/apply.svg" alt="">
                                            <div class="text-with-icon-text" >Принять</div>
                                        </div>
                                    </button>
                                    <button onclick="updateRequest(<?=$request['request_id']?>,3)" style="padding-right:20px;">
                                        <div class="text-with-icon">
                                            <img class="text-with-icon-icon" src="img/icons/decline.svg" alt="" >
                                            <div class="text-with-icon-text" >Отклонить</div>
                                        </div>
                                    </button>
                                    <?php
                                }
                                if($request['req_status']==2){
                                    echo "<div style='color:green; margin-right:20px;'>Заявка принята</div>";
                                }
                                if($request['req_status']==3){
                                    echo "<div style='color:red; margin-right:20px;'>Заявка отклонена</div>";
                                }
                                ?>
                            <a href="employer_vacancy.php?employer_id=<?=$request['user_id']?>&vacancy_id=<?=$request['id']?>">
                                <div class="text-with-icon">
                                    <img class="text-with-icon-icon" src="img/icons/view_orange.svg" alt="">
                                    <div class="text-with-icon-text" >Подробнее</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

    }
    if($user_type_id==2){
        $vacancy_id=isset($_POST['vacancy_id'])?$_POST['vacancy_id']:0;
        $sql="SELECT u.id as user_id,r.id,r.name as resume_title,c.title as city, u.name as employer_name,r.description as description, jc.title as job_title, req.vacancy_id, req.resume_id,
                    st.title as salary, emt.title as employment, ext.title as experience,
                    req.id as request_id, rt.id as req_type, rs.id as req_status,
                    req.date_sent as date_sent, req.date_responded as date_responded,
                    req.resume_id, req.vacancy_id,
                    SUBSTRING(r.description, 1, 300) as description
            FROM resume r
            inner join city c on c.id=r.city_id
            inner join user u on u.id=r.user_id
            inner join job_category jc  on jc.id=r.job_category_id
            inner join salary_type st  on st.id=r.salary_type_id
            inner join employment_type emt  on emt.id=r.employment_type_id
            inner join experience_type ext on ext.id=r.experience_type_id
            inner join request req on req.resume_id=r.id

            inner join request_type rt on rt.id=req.request_type_id
            inner join request_status rs on rs.id=req.request_status_id
            where 1=1 
            ";
        if($vacancy_id!=0){
            $sql.=" and req.vacancy_id=$vacancy_id";
        }

        if($request_status_id!=0){
            $sql.=" and rs.id=$request_status_id";
        }

        if($request_type_id!=0){
            $sql.=" and rt.id=$request_type_id ";
        }

        if($date_sort==1){
            $sql.="order by date_sent asc";
        }
        if($date_sort==2){
            $sql.="order by date_sent desc";
        }
        if($date_sort==3 && $request_type_id!=1){
            $sql.="order by date_responded asc";
        }
        if($date_sort==4 && $request_type_id!=1){
            $sql.="order by date_responded desc";
        }
        //echo "dude";

        //echo $sql;



        $requests=mysqli_query($link,$sql) or die ("Ошибка ".mysqli_error($link));
        if($requests){
            foreach ($requests as $request){
                //echo 'реквест';
                ?>
                <div class="main-card" style="border-bottom: 1px solid #7D1527;">
                    <div class="main-card-author" style="background-color: #7D1527;"><?=$request['employer_name']?></div>
                    <div class="main-card-brief">
                        <div class="main-card-job-name title-small" style="color:#7D1527; margin-bottom: 0"><?=$request['resume_title']?></div>
                        <div class="main-card-job-name" style="margin-bottom: 20px;"><?=$request['job_title']?></div>
                        <div class="main-card-info">
                            <div class="info-row">
                                <div class="info-row-item" style="margin-left:0;"><?=$request['city']?></div>
                                <div class="info-row-item"><?=$request['salary']?></div>
                                <div class="info-row-item"><?=$request['employment']?></div>
                                <div class="info-row-item"><?=$request['experience']?></div>
                            </div>
                        </div>
                        <div class="main-card-descr"><?=$request['description']?></div>
                        <div class="main-card-date">
                            <?php
                            if($request['date_sent']!=null){
                                ?>
                                <div class="main-card-date-item">
                                    <div>Дата отправки</div>
                                    <div><?=$request['date_sent']?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if($request['date_responded']!=null){
                                ?>
                                <div class="main-card-date-item">
                                    <div>Дата ответа</div>
                                    <div><?=$request['date_responded']?></div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div style="width:100%; display: flex; justify-content: end; flex-direction: row; padding-left:20px;">
                            <?php
                            if($request['req_status']==1 && $request['req_type']==1){
                                ?>
                                <button onclick="updateRequest(<?=$request['request_id']?>,2)" style="padding-right:20px;">
                                    <div class="text-with-icon">
                                        <img class="text-with-icon-icon" src="img/icons/apply_red.svg" alt="">
                                        <div class="text-with-icon-text" >Принять</div>
                                    </div>
                                </button>
                                <button onclick="updateRequest(<?=$request['request_id']?>,3)" style="padding-right:20px;">
                                    <div class="text-with-icon">
                                        <img class="text-with-icon-icon" src="img/icons/decline_red.svg" alt="">
                                        <div class="text-with-icon-text" >Отклонить</div>
                                    </div>
                                </button>
                                <?php
                            }
                            if($request['req_status']==2){
                                echo "<div style='color:green; margin-right:20px;'>Заявка принята</div>";
                            }
                            if($request['req_status']==3){
                                echo "<div style='color:red; margin-right:20px;'>Заявка отклонена</div>";
                            }
                            ?>
                            <a href="employee_resume.php?employee_id=<?=$request['user_id']?>&resume_id=<?=$request['id']?>">
                                <div class="text-with-icon">
                                    <img class="text-with-icon-icon" src="img/icons/view_red.svg" alt="">
                                    <div class="text-with-icon-text" >Подробнее</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

    }


}

}

