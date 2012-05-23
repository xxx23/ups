<?php
require_once('../config.php');
require_once('../session.php');
require_once ('../library/filter.php');
require_once($HOME_PATH.'Course_Admin/MSSQLWrapper.class.php');
checkAdmin();
$NKNU_DB_HOST = "NKNU_DB";
$NKNU_DB_USER = "Hsngccu";
$NKNU_DB_PASSWD = "Cyber3elearning";
$NKNU_DATABASE ="course_Hsngccu";
$login_id = optional_param("login_id","",PARAM_TEXT);
$setToResend = optional_param("resend",0,PARAM_INT);
$import_id = optional_param("import_id",0,PARAM_TEXT);
//Get All Course
putenv('FREETDSCONF=/usr/local/etc/freetds.conf');
$nknudb = new MSSQLWrapper(
        $NKNU_DB_HOST,
        $NKNU_DB_USER,
        $NKNU_DB_PASSWD,
        $NKNU_DATABASE    
    );
$message ="";
    if(!empty($login_id)){
        $identify_id = db_getOne("SELECT identify_id 
                        FROM register_basic
                        LEFT JOIN personal_basic ON register_basic.personal_id = personal_basic.personal_id
                        WHERE register_basic.login_id = '$login_id'");
 
    if(!empty($setToResend) && !empty($import_id)){
        $nknudb->query("
            update course set CourseState=1, CourseError=1 where Import_ID = '{$import_id}';
        ");
       $message = "編號:{$import_id} 之課程已經設定為重新匯入"; 
    }
   if(!empty($identify_id))
        $allCourse = $nknudb->getAll("
            SELECT CourseID,Import_ID,CourseName,TeacherList,CourseHour,CourseState,CourseError
            FROM Course
            WHERE TeacherList LIKE '%$identify_id%'
            ");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
    <head>
        <title>Find Reapeat</title>
<script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script> 
        <style type="text/css">
            table.dataList thead{
                background: #ccc;
            }
            tr.color {
                background:#eee;
            }
            .lightup{
                background:red;
                color:white;
            }
            .alert{
                width:70%;
                background:#ffcc99;
                margin: 0 auto;
            }
        </style>
<script type="text/javascript">
    $(document).ready(function(){    
setTimeout(function(){resizeParentIframe();},100);
    });
	function resizeParentIframe()
	{
		var theFrame = $('#certify_check', window.parent.document.body);
		if($(document.body).height()!=0)
            theFrame.height($(document.body).height()+200);
        else setTimeout(function(){resizeParentIframe();},200);
	}
        </script>
    </head>
    <body>
    <?php if(!empty($message)):?>
    <div class="alert"><?php echo $message?></div>
    <?php endif;?>
        <div style="margin: 0 auto;">
            <form action="CheckCertifySend.php" method="post">
                <input type="text" name="login_id" value="<?php echo $login_id ;?>"/>
                <input type="submit" />
            </form>
        </div>
        <?php if(!empty($login_id)): ?>
        <div class="personal">
            
            identify id:<?=$identify_id?>
        </div>
        <table class="dataList">
            <thead>
                <th>CourseID</th>
                <th>Import_ID</th>
                <th>CourseName</th>
                <th>CourseHour</th>
                <th>CourseState</th>
                <th>CourseError</th>
                <th>State</th>
            </thead>
            <tbody>
                <?php if(count($allCourse)!=0):?>
                <?php $line = 0;?>
                <?php foreach($allCourse as $course):?>
                
                <tr <?php echo $c =($line%2==1)?"class=\"color\"":"";?> >
                    <td><?=$course['CourseID']?></td>
                    <td><?=$course['Import_ID']?></td>
                    <td><?=$course['CourseName']?></td>
                    <td><?=$course['CourseHour']?></td>
                    <td><?=$course['CourseState']?></td>
                    <td><?=$course['CourseError']?></td>
                    <td><?php
                        if($course['CourseState'] && $course["CourseError"])
                            echo '等待高師大重新匯入(每天21:00過後匯入)';
                        else 
                            echo '已匯入<a href="?login_id='.$login_id.'&resend=1&import_id='.$course['Import_ID'].'"> (重新傳送)</a>';
                    ?></td>
                </tr>
                <tr <?php echo $c =($line%2==1)?"class=\"color\"":"";?> >
                    <td colspan="7"><?=str_replace($identify_id ,"<span class=\"lightup\">{$identify_id}</span>" ,$course['TeacherList']);?></td>
                </tr>
                <?php $line++;?>
                <?php endforeach;?>
                <?else:?>
                <tr><td>NOT Found</td></tr>
                <?endif;?>
            </tbody>
        </table>
        <?php endif; ?>
    </body>
</html>

