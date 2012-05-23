<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq
**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	//update_status ( "確認開課中" );
	require_once($RELEATED_PATH . "library/common.php");

	checkAdminAcademic();

    //開啟session
    session_start();
    // 如果 session還沒有被使用過的話 
    if(!isset($_SESSION['values']) ){
        //自學式的部份先寫在這
        $_SESSION['values']['course_property']          = "-1";
        $_SESSION['values']['begin_course_name']        = '';
        $_SESSION['values']['attribute']                = '2';
        $_SESSION['values']['begin_unit_cd']	        = '-1';
        $_SESSION['values']['article_number']           = '';
        $_SESSION['values']['deliver']                  = '';
        $_SESSION['values']['guest_allowed']            = '';
        /* course_stage是傳送高師大時所填的課程階段*/
        $_SESSION['values']['course_stage_option1']     = '';
        $_SESSION['values']['course_stage_option2']     = '';
        $_SESSION['values']['course_stage_option3']     = '';
        $_SESSION['values']['course_stage_option4']     = '';
        $_SESSION['values']['course_stage']             = '';
        $_SESSION['values']['career_stage']             = '';
        $_SESSION['values']['certify']                  = '';
        $_SESSION['values']['course_unit']              = '';
        $_SESSION['values']['begin_unit_cd']            = '';
        $_SESSION['values']['course_duration']          = '';
        $_SESSION['values']['criteria_total']           = '';
        $_SESSION['values']['criteria_content_hour_1']  = '';
        $_SESSION['values']['criteria_content_hour_2']  = '';
        $_SESSION['values']['director_name']            = '';
        $_SESSION['values']['director_tel_area']        = '';
        $_SESSION['values']['director_tel_left']        = '';
        $_SESSION['values']['director_tel_ext']         = '';
        $_SESSION['values']['director_email']           = '';
        $_SESSION['values']['note']                     = '';
        
        //以下為教導式的部份
        $_SESSION['values']['take_hour'] = '';
		$_SESSION['values']['inner_course_cd']	= '';
		$_SESSION['values']['d_course_begin']	= '';
		$_SESSION['values']['d_course_end']	= '';
		$_SESSION['values']['d_public_day']	= '';
		$_SESSION['values']['d_select_begin']	= '';
		$_SESSION['values']['d_select_end']	= '';
		$_SESSION['values']['course_year']	= this_semester('y');
        $_SESSION['values']['course_session']	= this_semester('s');
        $_SESSION['values']['quantity']     	    = '';
        $_SESSION['values']['auto_admission']           = '';    
	}

    //如果session還沒有被使用過的話
    if(!isset($_SESSION['errors'])){	
        //以下為自學式課程原有的部份
        $_SESSION['errors']['course_property']      = 'hidden';
        $_SESSION['errors']['begin_course_name']    = 'hidden';
		$_SESSION['errors']['begin_unit_cd']	    = 'hidden';
        $_SESSION['errors']['article_number']       = 'hidden';
        /* course_stage 是傳送高師大時所填的 課程階段 */
        $_SESSION['errors']['course_stage']         = 'hidden';
        $_SESSION['errors']['course_stage_option1'] = 'hidden';
        $_SESSION['errors']['course_stage_option2'] = 'hidden';
        $_SESSION['errors']['course_stage_option3'] = 'hidden';
        $_SESSION['errors']['course_stage_option4'] = 'hidden';
        $_SESSION['errors']['career_stage']         = 'hidden';
        $_SESSION['errors']['certify']              = 'hidden';
        /* course_unit 是課程類別*/
        $_SESSION['errors']['course_unit']          = 'hidden';
        $_SESSION['errors']['begin_unit_cd']        = 'hidden';
        $_SESSION['errors']['course_duration']      = 'hidden';
        $_SESSION['errors']['criteria_total']       = 'hidden';    
        /* criteria_content_hour 是課程需觀看的教材時數 */
        $_SESSION['errors']['criteria_content_hour']= 'hidden';
        $_SESSION['errors']['director_name']        = 'hidden';
        $_SESSION['errors']['director_tel']         = 'hidden';
        $_SESSION['errors']['director_tel_area']    = 'hidden';
        $_SESSION['errors']['director_tel_left']    = 'hidden';
        $_SESSION['errors']['director_tel_ext']     = 'hidden';
        $_SESSION['errors']['director_email']       = 'hidden';
        $_SESSION['errors']['note']                 = 'hidden';
        // 2010/01/31 更改開設課程時 課程時數填寫做修正，不使用下拉式選單 以正常的text輸入
        $_SESSION['errors']['criteria_content_hour_1'] = 'hidden';
        $_SESSION['errors']['criteria_content_hour_2'] = 'hidden';

        //以下為教導式課程多出來的部份
        $_SESSION['errors']['take_hour']            = 'hidden';
        $_SESSION['errors']['inner_course_cd']	    = 'hidden';		
		$_SESSION['errors']['d_course_begin']	    = 'hidden';
		$_SESSION['errors']['d_course_end']		    = 'hidden';
		$_SESSION['errors']['d_public_day']		    = 'hidden';
		$_SESSION['errors']['d_select_begin']	    = 'hidden';
		$_SESSION['errors']['d_select_end']		    = 'hidden';
		$_SESSION['errors']['course_year']		    = 'hidden';
        $_SESSION['errors']['course_session']	    = 'hidden';	
        $_SESSION['errors']['quantity']     	    = 'hidden';	
	}

    // modify by Samuel @ 2009/12/11
    // 重新寫如果資料使用POST 重新assign值的話 在這裡指定
    // 接收到東西的話，使用post去更改session的值
    
    if(isset($_POST['attribute']))
        $_SESSION['values']['attribute'] = $_POST['attribute'];

    // 以下是自學式課程的部份
    if(!isset($_GET['s']))
    {
        if($_SESSION['values']['attribute'] != 2) // 即已經做了選擇了
        {
            $_SESSION['values']['course_property']          = $_POST['course_property'];
            $_SESSION['values']['attribute']                = $_POST['attribute'];
            $_SESSION['values']['begin_course_name']        = $_POST['begin_course_name'];
            $_SESSION['values']['deliver']                  = $_POST['deliver'];
            $_SESSION['values']['guest_allowed']            = $_POST['guest_allowed'];
            $_SESSION['values']['article_number']           = $_POST['article_number'];
            $_SESSION['values']['course_stage_option1']     = $_POST['course_stage_option1'];
            $_SESSION['values']['course_stage_option2']     = $_POST['course_stage_option2'];
            $_SESSION['values']['course_stage_option3']     = $_POST['course_stage_option3'];
            $_SESSION['values']['course_stage_option4']     = $_POST['course_stage_option4'];
            $_SESSION['values']['career_stage']             = $_POST['career_stage'];
            $_SESSION['values']['certify']                  = $_POST['certify'];
            $_SESSION['values']['course_unit']              = $_POST['course_unit'];
            $_SESSION['values']['begin_unit_cd']            = $_POST['begin_unit_cd'];
            $_SESSION['values']['course_duration']          = $_POST['course_duration'];
            $_SESSION['values']['criteria_content_hour_1']  = $_POST['criteria_content_hour_1'];
            $_SESSION['values']['criteria_content_hour_2']  = $_POST['criteria_content_hour_2'];
            $_SESSION['values']['criteria_total']           = $_POST['criteria_total'];
            $_SESSION['values']['director_name']            = $_POST['director_name'];
            $_SESSION['values']['director_tel_area']        = $_POST['director_tel_area'];
            $_SESSION['values']['director_tel_left']        = $_POST['director_tel_left'];
            $_SESSION['values']['director_tel_ext']         = $_POST['director_tel_ext'];
            $_SESSION['values']['director_email']           = $_POST['director_email'];
            $_SESSION['values']['note']                     = $_POST['note'];
            // end modification
            
            // modify by Samuel @ 2010/03/16
            // 這裡新增教導式課程有一些欄位的POST
            $_SESSION['values']['take_hour']                = $_POST['take_hour'];
            $_SESSION['values']['d_course_begin']           = $_POST['d_course_begin'];
            $_SESSION['values']['d_course_end']             = $_POST['d_course_end'];
            $_SESSION['values']['d_select_begin']           = $_POST['d_select_begin'];
            $_SESSION['values']['d_select_end']             = $_POST['d_select_end'];
            $_SESSION['values']['d_public_day']             = $_POST['d_public_day'];
            $_SESSION['values']['quantity']                 = $_POST['quantity'];
            $_SESSION['values']['auto_admission']           = $_POST['auto_admission'];
            // modify by Samuel @ 2010/03/16 
            // 新增教導式 一些欄位 SESSION的改變
            
            /* 課程的課程時數 */
            if($_POST['take_hour'] == NULL)
                $_SESSION['errors']['take_hour'] = 'error';
            else
                $_SESSION['errors']['take_hour'] = 'hidden';

            if($_SESSION['is_load'])
            {
                /* 判斷課程性質的session */
                if($_POST['course_property'] == -1)
                    $_SESSION['errors']['course_property'] = 'error';
                else
                    $_SESSION['errors']['course_property'] = 'hidden';
                /* 判斷課程名稱的session */
                if($_POST['begin_course_name'] == NULL)
                    $_SESSION['errors']['begin_course_name'] = 'error';
                else
                    $_SESSION['errors']['begin_course_name'] = 'hidden';
                /* 判課認証時數 */
                if($_POST['certify'] == NULL)
                    $_SESSION['errors']['certify'] = 'error';
                else
                    $_SESSION['errors']['certify'] = 'hidden';
                /* 判斷開課類別 */
                if($_POST['course_unit'] == -1)
                    $_SESSION['errors']['course_unit'] = 'error';
                else
                    $_SESSION['errors']['course_unit'] = 'hidden';
                /* 判斷課程子類別 */
                if($_POST['begin_unit_cd'] == -1)
                    $_SESSION['errors']['begin_unit_cd'] = 'error';
                else
                    $_SESSION['errors']['begin_unit_cd'] = 'hidden';
                /* 判斷課程時間 */
                if($_POST['course_duration'] == 0)
                    $_SESSION['errors']['course_duration'] = 'error';
                else
                    $_SESSION['errors']['course_duration'] = 'hidden';
                /* 判斷通過條件總分 */
                if($_POST['criteria_total'] == NULL)
                    $_SESSION['errors']['criteria_total'] = 'error';
                else
                    $_SESSION['errors']['criteria_total'] = 'hidden';
                /* 判斷通過條件的觀看教材的時間 */
                /* 因應 2010/01/31 教育部人員需求，將課程時數做修改，所以session的部份已不用舊的
                 *
                if(($_POST['criteria_content_hour_1'] == NULL || ($_POST['criteria_content_hour_2'] == -1))
                    $_SESSION['errors']['criteria_content_hour'] = 'error';
                else
                    $_SESSION['errors']['criteria_content_hour'] = 'hidden';
                 */
                /* 判斷課程觀看時間 - 時*/
                if($_POST['criteria_content_hour_1'] == NULL)
                    $_SESSION['errors']['criteria_content_hour_1'] = 'error';
                else
                    $_SESSION['errors']['criteria_content_hour_1'] = 'hidden';
                /* 判斷課程觀看時間 - 分*/
                if($_POST['criteria_content_hour_2'] == NULL)
                    $_SESSION['errors']['criteria_content_hour_2'] = 'error';
                else
                    $_SESSION['errors']['criteria_content_hour_2'] = 'hidden';
                /* 判斷承辦人的名字 */
                if($_POST['director_name'] == NULL)
                    $_SESSION['errors']['director_name'] = 'error';
                else
                    $_SESSION['errors']['director_name'] = 'hidden';

                /* 驗証承辦人的電話 */
                if(($_POST['director_tel_area'] == NULL)|| ($_POST['director_tel_left'] == NULL))
                    $_SESSION['errors']['director_tel'] = 'error';
                else
                    $_SESSION['errors']['director_tel'] = 'hidden';

                /* 驗証承辦人的email */
                if($_POST['director_email'] == NULL)
                    $_SESSION['errors']['director_email'] = 'error';
                else
                    $_SESSION['errors']['director_email'] = 'hidden';

                if($_POST['deliver'] == 1) /* 如果要傳送高師大 才需要做以下的驗証！*/
                {
                    /* 驗証依據文號 */
                    if($_POST['article_number'] == NULL)
                        $_SESSION['errors']['article_number'] = 'error';
                    else
                        $_SESSION['errors']['article_number'] = 'hidden';
                    /* 驗証課程階段別 */
                    if(!isset($_POST['course_stage_option1']) && !isset($_POST['course_stage_option2']) && !isset($_POST['course_stage_option3']) && !isset($_POST['course_stage_option4']) )
                        $_SESSION['errors']['course_stage'] = 'error';
                    else
                        $_SESSION['errors']['course_stage'] = 'hidden';
                    /* 驗証課程對象階段別 */
                    if($_POST['career_stage'] == '無')
                        $_SESSION['errors']['career_stage'] = 'error';
                    else
                        $_SESSION['errors']['career_stage'] = 'hidden';
                }

            }
        }
    }
    //new smarty
	require_once($HOME_PATH . 'library/smarty_init.php');

    // modify by Samuel @ 2009/12/11
    // 修改一些欄位 且變更欄位assign的方式 原本是使用post 現在使用session

    /* 課程的子類別assign給department */
    if($_SESSION['values']['course_unit'] != NULL)
        $department = $_SESSION['values']['course_unit'];
    else
        $department = -1;

    $tpl->assign("department",$department);
    /* 課程的名稱 */
    $tpl->assign("begin_course_name",$_SESSION['values']['begin_course_name']);
    $tpl->assign("begin_course_nameFailed",$_SESSION['errors']['begin_course_name']);

    $tpl->assign("attribute",$_SESSION['values']['attribute']);
    $tpl->assign("course_property",$_SESSION['values']['course_property']);
    $tpl->assign("course_propertyFailed",$_SESSION['errors']['course_property']);
    /* 課程是否傳送高師大 */
    $tpl->assign("deliver",$_SESSION['values']['deliver']);
    /* 課程是否允許讓訪客觀看 */
    $tpl->assign("guest_allowed",$_SESSION['values']['guest_allowed']);
    /* 課程的課程時數  */
    $tpl->assign("take_hour",$_SESSION['values']['take_hour']);
    $tpl->assign("take_hourFailed",$_SESSION['errors']['take_hour']);
    /* 課程的修課人數 (目前只有教導式的課程才有)*/
    $tpl->assign("quantity",$_SESSION['values']['quantity']);
    $tpl->assign("quantityFailed",$_SESSION['errors']['quantity']);
    /* 課程的依據文號 */
    $tpl->assign("article_number",$_SESSION['values']['article_number']);
    $tpl->assign("article_numberFailed",$_SESSION['errors']['article_number']);
    /* course stage 是傳送高師大的欄位 */
    $tpl->assign("course_stage_option1",$_SESSION['values']['course_stage_option1']);
    $tpl->assign("course_stage_option2",$_SESSION['values']['course_stage_option2']);
    $tpl->assign("course_stage_option3",$_SESSION['values']['course_stage_option3']);
    $tpl->assign("course_stage_option4",$_SESSION['values']['course_stage_option4']);
    $tpl->assign("course_stageFailed",$_SESSION['errors']['course_stage']);
    /* 觀看課程的用者的職業階級 */
    $tpl->assign("career_stage",$_SESSION['values']['career_stage']);
    $tpl->assign("career_stageFailed",$_SESSION['errors']['career_stage']);
    /* 課程的認証時數 */
    $tpl->assign("certify",$_SESSION['values']['certify']);
    $tpl->assign("certifyFailed",$_SESSION['errors']['certify']);
    /* 課程的類別 */
    $tpl->assign("course_unit",$_SESSION['values']['course_unit']);
    $tpl->assign("course_unitFailed",$_SESSION['errors']['course_unit']);
    /* 課程的子類別 */
    $tpl->assign("begin_unit_cd",$_SESSION['values']['begin_unit_cd']);
    $tpl->assign("begin_unit_cdFailed",$_SESSION['errors']['begin_unit_cd']);
    /* 課程的修課期限 */
    $tpl->assign("course_duration",$_SESSION['values']['course_duration']);
    $tpl->assign("course_durationFailed",$_SESSION['errors']['course_duration']);
    /* 線上課程的測驗通過總分 */
    $tpl->assign("criteria_total",$_SESSION['values']['criteria_total']);
    $tpl->assign("criteria_totalFailed",$_SESSION['errors']['criteria_total']);
    /* 課程觀看線上教材的時間為何 */
    $tpl->assign("criteria_content_hour_1",$_SESSION['values']['criteria_content_hour_1']);
    $tpl->assign("criteria_content_hour_1Failed",$_SESSION['errors']['criteria_content_hour_1']);
    $tpl->assign("criteria_content_hour_2",$_SESSION['values']['criteria_content_hour_2']);
    $tpl->assign("criteria_content_hour_2Failed",$_SESSION['errors']['criteria_content_hour_2']);
    //$tpl->assign("criteria_content_hourFailed",$_SESSION['errors']['criteria_content_hour']);
    /*承辦人名字*/
    $tpl->assign("director_name",$_SESSION['values']['director_name']);
    $tpl->assign("director_nameFailed",$_SESSION['errors']['director_name']);
    /* 承辦人電話 */
    $tpl->assign("director_tel_area",$_SESSION['values']['director_tel_area']);
    $tpl->assign("director_tel_left",$_SESSION['values']['director_tel_left']);
    $tpl->assign("director_tel_ext",$_SESSION['values']['director_tel_ext']);
    $tpl->assign("director_telFailed",$_SESSION['errors']['director_tel']);
    /* 承辦人 email */
    $tpl->assign("director_email",$_SESSION['values']['director_email']);
    $tpl->assign("director_emailFailed",$_SESSION['errors']['director_email']);
    /* 課程是否自動審查 (教導式課程專用)*/
    $tpl->assign("auto_admission",$_SESSION['values']['auto_admission']);
    /* 註解 */
    $tpl->assign("note",$_SESSION['values']['note']);
    $tpl->assign("noteFailed",$_SESSION['errors']['note']);
    // end modification
    
    // modify by Samuel @ 09/08/28
	// 修改一些欄位 並且變更tpl
    /* 課程的屬性 */

    //$attribute = $_POST['attribute'];
	//if(!isset($attribute)) $attribute = 2 ; // 等於2是請選擇的選項
    //$tpl->assign("attribute",$attribute);
    
    $deliver = $_POST['deliver'];
	if(!isset($deliver)) $deliver = 0 ; // default是暫時不傳送高師大
    
    /*
    $course_stage = $_POST['course_stage'];
	if(!isset($course_stage)) $course_stage = -1 ;
     */
	$career_stage = $_POST['career_stage'];
	if(!isset($career_stage)) $career_stage = "無";

    /*
    $department = $_POST['course_unit'];
	if(!isset($department)) $department = 0 ;
    */
    
    // modify by Samuel @ 2009/11/20
    // 修改 course_stage 因為要複選，只好這樣做。
    //$tpl->assign("course_stage_option1",$_POST['course_stage_option1']);
    //$tpl->assign("course_stage_option2",$_POST['course_stage_option2']);
    //$tpl->assign("course_stage_option3",$_POST['course_stage_option3']);
    //$tpl->assign("course_stage_option4",$_POST['course_stage_option4']);
    // end here

    // modify by Samuel @ 2009/11/22
    // 更改承辦人電話欄位，以正確格式能傳送高師大。
    //$tpl->assign("director_tel_area",$_POST['director_tel_area']);
    //$tpl->assign("director_tel_left",$_POST['director_tel_left']);
    //$tpl->assign("director_tel_ext",$_POST['director_tel_ext']);
    // end of modification

    // modify by Samuel @ 2009/12/10
    // 嘗試更新將資料都暫存在 $_SESSION 裡面，以方便把資料丟過去tpl的時候可顯示錯誤。


    // end of modification

    /*
	$tpl->assign("course_property",$_POST['course_property']);
	$tpl->assign("attribute",$attribute);
	$tpl->assign("deliver",$deliver);
    $tpl->assign("course_stage",$course_stage);
	$tpl->assign("career_stage",$career_stage);
	$tpl->assign("certify",$_POST['certify']);
	$tpl->assign("department",$department);
	$tpl->assign("begin_unit_cd",$begin_unit_cd);
	$tpl->assign("course_unit",$_POST['course_unit']);
	$tpl->assign("course_duration",$_POST['course_duration']);
	$tpl->assign("criteria_total",$_POST['criteria_total']);
	$tpl->assign("criteria_content_hour_1",$_POST['criteria_content_hour_1']);
	$tpl->assign("criteria_content_hour_2",$_POST['criteria_content_hour_2']);
	$tpl->assign("director_name",$_POST['director_name']);
	$tpl->assign("director_tel",$_POST['director_tel']);
	$tpl->assign("director_email",$_POST['director_email']);
	$tpl->assign("article_number",$_POST['article_number']);
    $tpl->assign("guest_allowed",$_POST['guest_allowed']);
      
    $_SESSION['errors']['begin_course_name'] = 'error';
    //-------------開課名稱--------------------
	$tpl->assign("valueOfBegin_course_name",$_POST['begin_course_name']);
	$tpl->assign("begin_course_nameFailed",$_SESSION['errors']['begin_course_name']);	

	//-------------開課單位--------------------
	$tpl->assign("valueOfBegin_unit_cd",$_SESSION['values']['begin_unit_cd']);
	$tpl->assign("begin_unit_cdFailed", $_SESSION['errors']['begin_unit_cd']);	
     */
    
    //-------------開課開始日期--------------------
	$tpl->assign("d_course_begin",$_SESSION['values']['d_course_begin']);
	$tpl->assign("d_course_beginFailed",$_SESSION['errors']['d_course_begin']);	
	
	//-------------開課結束日期--------------------
	$tpl->assign("d_course_end",$_SESSION['values']['d_course_end']);
	$tpl->assign("d_course_endFailed",$_SESSION['errors']['d_course_end']);	
	
	//-------------開課公開日期--------------------
	$tpl->assign("d_public_day",$_SESSION['values']['d_public_day']);
	$tpl->assign("d_public_dayFailed",$_SESSION['errors']['d_public_day']);	
	
	//-------------選課開始日期--------------------
	$tpl->assign("d_select_begin",$_SESSION['values']['d_select_begin']);
	$tpl->assign("d_select_beginFailed",$_SESSION['errors']['d_select_begin']);	
	
	//-------------選課結束日期--------------------
	$tpl->assign("d_select_end",$_SESSION['values']['d_select_end']);
	$tpl->assign("d_select_endFailed",$_SESSION['errors']['d_select_end']);		
	
	
	//-------------開課所屬的學年--------------------
	$tpl->assign("valueOfCourse_year",$_SESSION['values']['course_year']);
	$tpl->assign("course_yearFailed",$_SESSION['errors']['course_year']);		
	
	//-------------開課所屬的學期--------------------
	$tpl->assign("valueOfCourse_session",$_SESSION['values']['course_session']);
	$tpl->assign("course_sessionFailed",$_SESSION['errors']['course_session']);		

    
	// add by Samuel @ 2009/08/01
	// 找出一共有多少課程屬性
	$sql = "SELECT * FROM course_property";
	$total_course_property = db_getAll($sql);
	$tpl->assign("total_course_property",$total_course_property);

	// add by Samuel @ 2009/08/28
	// 找出目前的課程類別
	$sql = "SELECT * FROM lrtunit_basic_ WHERE department = -1 ORDER BY unit_cd";
	$total_course_unit = db_getAll($sql);
	$tpl->assign("total_course_unit",$total_course_unit);

	// 找出目前課程的子類別
	if($department != -1)
	{
	  $sql = "SELECT * FROM lrtunit_basic_ WHERE department = {$department}";
	  $total_course_subunit = db_getAll($sql);
	  $tpl->assign("total_course_subunit",$total_course_subunit);
	}

	//驗證表單
	$tpl->assign("actionPage","./validate_begin_course.php?validationType=php");	
	//輸出頁面
	assignTemplate($tpl, "/course_admin/begin_course.tpl");	


/*

2/1 ~ 7/31 是第二學期, 則 系統日期的 該年-1

8/ 1 ~ 1/31 是第一學期 則學年是 系統日期的 該年

像現在 開始的 學年是 96 學年 第一學期

到明年開始的就是  學年是 96 學年 第二學期 但系統日期已經是 97了

*/

function this_semester($str){
	
	$year = date('Y')-1911;
	$month = date('n');
	$day = date('j');
	
	if( $month >= 2  && $month <= 7 ){
		$session = 2;
		$y = $year - 1;
	}
	else{
		$session = 1;
		$y = $year ;		
	}
	if($str === "y")
		return $y;
	else
		return $session;	
}
?>
