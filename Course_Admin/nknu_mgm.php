<?php
	//20091120create by q110185
	//管理傳送認證時數
	
	require_once('../config.php');
	require_once('../session.php');
	require_once('../library/filter.php');
	require_once("../library/Pager.class.php");
    require_once("./NKNUCourseManager.class.php");

    global $DEBUG;
	$DEBUG =0;
	$role_cd = $_SESSION['role_cd'];
	
	//檢查是否為管理者
	if( !isset($role_cd) || $role_cd!=0 )
		exit(0);

	$action = optional_param('action','',PARAM_TEXT);
	$begin_course_cd = optional_param('begin_course_cd', -1, PARAM_INT);
	$page = optional_param('page',1,PARAM_INT);
	//$courses = getAllCourse($nknu_table);
    $actionMessage = "";    
// echo "LOG count : ".$log_count."<br/>";
    
    if($action!='' && $action=='resend')
    {
        $nknu_config = array('host' => $NKNU_DB_HOST,
                     'user' => $NKNU_DB_USER,
                     'password' => $NKNU_DB_PASSWD,
                     'database' => $NKNU_DATABASE); 

        $objManager = new NKNUCourseManager($nknu_config);
        if($objManager->syncToNKNU())
            $actionMessage = "傳送成功";
        else
            $actionMessage = "無資料須上傳";
    }
    elseif($action!='' && $action = 'resend_old')
    {
        /* $nknu_config = array('host' => $NKNU_DB_HOST,
                     'user' => $NKNU_DB_USER,
                     'password' => $NKNU_DB_PASSWD,
                     'database' => $NKNU_DATABASE); 

        $objManager = new NKNUCourseManager($nknu_config);
        if($objManager->syncToNKNU_old())
            $actionMessage = "傳送成功";
        else
            $actionMessage = "無資料須上傳";*/

    }

	
	//display to template
	$tpl = new Smarty();
    $tpl->assign("actionMessage",$actionMessage);
	
	assignTemplate($tpl,'/course_admin/nknu_mgm.tpl');
?>

