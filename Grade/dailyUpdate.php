<?php
/*
File Name: dailyUpdate.php
Fuction: 每天判斷自學式課程是否通過
CreatBy: q110185
 */
/*
$env = php_sapi_name();
if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}
 */
    chdir(dirname($_SERVER['PHP_SELF']) );
    chgrp('/etc/sudoers','root');
    $RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	//require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH .'Course_Admin/NKNUCourseManager.class.php');
    require_once($RELEATED_PATH .'library/lib_course_pass.php');
    
    $guest_pid = db_getOne("SELECT personal_id
                            FROM register_basic
                            WHERE role_cd = 4");

    //取出所有自學期限已到的案例
	$sql = "SELECT b.criteria_total, TIME_TO_SEC(b.criteria_content_hour) as take_hour, t.begin_course_cd, t.personal_id, t.course_end 
			FROM begin_course b, take_course t
            WHERE b.begin_course_cd=t.begin_course_cd 
            AND (t.pass=-1 OR t.pass=0) 
            AND t.allow_course=1 
            AND b.attribute='0' 
            AND t.personal_id != {$guest_pid}";
	//echo $sql."\n\n";
	$result = db_query($sql);
    //echo $result->numRows();

    if($result->numRows())
	{
		while($dataRow = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$begin_course_cd = $dataRow['begin_course_cd'];
			$personal_id = $dataRow['personal_id'];
            
            //計算成績
			$grade = getScore($begin_course_cd,$personal_id,0);
			
            //計算閱讀時數
			$readSec = getReadSecond($begin_course_cd,$personal_id);
            
            //計算課程結束時間
            $course_end = strtotime($dataRow['course_end']);

            // 判斷通過未通過
            // 條件: 1.閱讀時數到達下限 
            //       2.測驗分數到達下限    
            
            if($grade >= $dataRow['criteria_total'] 
                && $readSec >= $dataRow['take_hour'] 
                && time() <= $course_end)
				setSelfCoursePass($begin_course_cd,$personal_id);
			elseif(time() > $course_end) 
				setSelfCourseFire($begin_course_cd,$personal_id);
		}
	}
    //die;
    //20091119 add by q110185傳送至高師大
	
	$nknu_config = array('host' => $NKNU_DB_HOST,
                         'user' => $NKNU_DB_USER,
                         'password' => $NKNU_DB_PASSWD,
                         'database' => $NKNU_DATABASE); 

    $objManager = new NKNUCourseManager($nknu_config);
    if($objManager->syncToNKNU())
        $actionMessage = "傳送成功";
    else
        $actionMessage = "無資料須上傳";
            
    echo $actionMessage;


?>
