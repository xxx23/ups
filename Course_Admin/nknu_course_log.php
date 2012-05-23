<?php
	//show平台傳送至高師大自己留下的紀錄
	//20091120create by q110185
	//管理傳送認證時數
	
	require_once('../config.php');
	require_once('../session.php');
	require_once('../library/filter.php');
	require_once("../library/Pager.class.php");
 
    //ini_set('display_errors',1);
    //error_reporting(E_ALL); 	
    $page = optional_param('page',1,PARAM_INT);
    $date_start = optional_param('date_start','',PARAM_TEXT);
    $date_end = optional_param('date_end','',PARAM_TEXT);
    $role_cd = $_SESSION['role_cd'];

    if(!isset($role_cd) || $role_cd !=0)    
        exit(0);    
    if($date_start != '' and $date_end != '')
        $total_data = db_getOne("SELECT COUNT(*) FROM nknu_transfer_log WHERE log_time BETWEEN '{$date_start}' AND '{$date_end}';");
    else
        $total_data = db_getOne("SELECT COUNT(*) FROM nknu_transfer_log WHERE 1");
    $page_meta = array( 'page'=>$page,
                        'per_page'=>10,
                        'data_cnt'=>$total_data);
    $pager = new Pager($page_meta);
    if($date_start != '' and $date_end != '')
        $sql= "SELECT * FROM nknu_transfer_log WHERE log_time BETWEEN '{$date_start}' AND '{$date_end}' ORDER BY log_time DESC ".$pager->getSqlLimit();
    else
         $sql= 'SELECT * FROM nknu_transfer_log ORDER BY log_time DESC'.$pager->getSqlLimit();
    $result = db_query($sql);

    $course_logs = null;
    while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
    {
        $course_logs[]=$row;
    }
   /* foreach($nknu_table as $key=>$value)
    {
        
        echo '<li>{$log.'.strtolower($key).'}</li>'."\n";
    }
    well_print($course_logs);
    */    
    $pageOpt =$pager->getSmartyHtmlOptions();
    $tpl = new Smarty();

    $tpl->assign('date_start',$date_start);
    $tpl->assign('date_end',$date_end);

    $tpl->assign('course_logs',$course_logs);
    $tpl->assign('page_sel',$pager->thisPage());
    $tpl->assign('page_names',$pageOpt['page_names']);

    $tpl->assign('page_ids',$pageOpt['page_ids']);
    $tpl->assign('previousPage',$pager->previousPage());
    $tpl->assign('nextPage',$pager->nextPage());
	assignTemplate($tpl,'/course_admin/nknu_course_log.tpl');

?>
