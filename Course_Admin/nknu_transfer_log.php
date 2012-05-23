<?php
	//20091120create by q110185
	//show出認證時數傳送紀錄
	//20091120create by q110185
	//管理傳送認證時數
	
	require_once('../config.php');
	require_once('../session.php');
	require_once('../library/filter.php');
	require_once("../library/Pager.class.php");
	require_Once('./MSSQLWrapper.class.php');
	$role_cd = $_SESSION['role_cd'];
	
	//檢查是否為管理者
	if(!isset($role_cd) || $role_cd!=0)
		exit(0);
	global $DB;
    $DB = new MSSQLWrapper($NKNU_DB_HOST,
                           $NKNU_DB_USER,
                           $NKNU_DB_PASSWD,
                           $NKNU_DATABASE);
    $page = optional_param('page',1,PARAM_INT);
    
    $date_start = optional_param('date_start','',PARAM_TEXT);
    $date_end = optional_param('date_end','',PARAM_TEXT);

    $condition = '';

    if($date_start != '' and $date_end !='')
        $condition=" log_date BETWEEN '{$date_start}' AND '{$date_end}'";

    $log_count = getTransferLogCount($condition);
    
	$meta = array("page"=>$page,"per_page"=>10,"data_cnt"=>$log_count);
	$pager = new Pager($meta);
	
	$pagerOpt = $pager->getSmartyHtmlOptions();

	$logs = array();
	
	$logs =getTransferLog($pager->getOffset(),$pager->getPerpage(),$condition);
	//debug_print(mssql_get_last_message());
	
	//清除暫存 
	//關閉連結
	mssql_close($nknu_link);
	
	//display to template
    $tpl = new Smarty();
    $tpl->assign("date_start",$date_start);
    $tpl->assign("date_end",$date_end);
	$tpl->assign("page_ids",$pagerOpt['page_ids']);
	$tpl->assign("page_names",$pagerOpt['page_names']);
    $tpl->assign("page_sel",$pagerOpt['page_sel']);
    $tpl->assign("nextPage",$pager->nextPage());
    $tpl->assign("previousPage",$pager->previousPage());
	$tpl->assign('logs',$logs);
	assignTemplate($tpl,'/course_admin/nknu_transfer_log.tpl');
	
	function getTransferLogCount($condition='')
	{
        global $DB;
		if($condition == '')
			$sql = "SELECT count(*) AS log_count FROM transfer_log ";
		else $sql = "SELECT count(*) AS log_count FROM transfer_log WHERE $condition";
		//debug_print(mssql_get_last_message());
		return $DB->getOne($sql);
	}
	
	function getTransferLog($offset,$count,$condition ='')
	{
        global $DB;
        $tmp_cnt = $count+$offset;
        if($condition == '')
        {
		    $sql = "SELECT * FROM(
					    SELECT TOP {$count} * FROM(
						    SELECT TOP {$tmp_cnt} * 
						    FROM transfer_log
						    ORDER BY id DESC
					    )temp1 ORDER BY id 
				    )temp2 ORDER BY id DESC";
        }
        else
        {
              $sql = "SELECT * FROM(
					    SELECT TOP {$count} * FROM(
						    SELECT TOP {$tmp_cnt} * 
						    FROM transfer_log
						    WHERE {$condition} ORDER BY id DESC
					    )temp1 ORDER BY id 
				    )temp2 ORDER BY id DESC ";
        }
        $data = $DB->getAll($sql);
        //debug_print(mssql_get_last_message());
		return $data;
	}

?>
