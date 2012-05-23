<?php
	/************************************************************************/
	/*id: learning_tracking.php v1.0 2007/9/4 by hushpuppy Exp.				*/
	/*function: 教材學習追蹤，當點擊教材node時，送出ajax由本程式接收request		*/
	/************************************************************************/
	
	include "../../config.php";
	include "../../session.php";
	include "../lib/learning_record.php";
	//include "../../lib/date.php";
	//checkMenu("/Teaching_Material/stu_textbook_content.php");

    //joyce-------0228
    //為解決登出session清空比時數更新快
    //參數不從session讀 
    $begin_course_cd = $_SESSION['begin_course_cd'];

    $Menu_id = $_GET['Menu_id'];
    $Personal_id = $_GET['Personal_id'];
    $Begin_course_cd  = $_GET['Begin_course_cd'];

    $Frame  = $_GET['Frame'];

    //joyce----0312
    //再用開啟視窗方式閱讀之下
    //使用者又去點選另一個課程
    //則不去計開啟視窗的時數了
    if($Frame == 1 && strlen($begin_course_cd)!=0 && $begin_course_cd!= $Begin_course_cd )
        echo "0";
    else
    {
	    $total = record_hold_time($Menu_id,$Personal_id,$Begin_course_cd);
        echo "1";
    }
	file_put_contents("1test.txt", '1231231232');
?>
