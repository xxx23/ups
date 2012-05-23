<?php

	
	
	require_once("../config.php");
	require_once("../session.php");
	checkAdmin();
	global $DB_CONN;
	$cd = $_GET['cd'];

	if($cd == null) //È¤ÕÆ¹Ý¨Æ˜à ½
		$sql = "SELECT * FROM lrtunit_basic_ WHERE department=-1 ORDER BY unit_cd";
	else
		$sql = "SELECT * FROM lrtunit_basic_ WHERE department=$cd ORDER BY unit_cd";


	$result = $DB_CONN->query($sql);
	$tpl = new Smarty();
	
	//6/10 new by lulu - start
	$debug = 1;
	
	$unit_list = $_GET['unit_list'];
	
	$unit_array = array();
	$array_cnt=0;
	
	$tok = strtok($unit_list, "_");
	while ($tok != false) {
	    $unit_array[$array_cnt] = $tok;
		$array_cnt++;
	    $tok = strtok("_");
	}
	
	$n_of_unit = count($unit_array);
	for($i=0;$i< $n_of_unit-1;$i++){
		$pre_unit_list = $pre_unit_list . "_" . $unit_array[$i] ;
	}
	
	$tpl->assign('pre_unit_list', $pre_unit_list);
	$tpl->assign('unit_list', $unit_list);
	$tpl->assign('unit_array', $unit_array);
	
	
	//6/10 new by lulu - end
	
	
	//6/10 night new by lulu - start
	$cd_list = $_GET['cd_list'];
	
	$cd_array = array();
	$array_cnt=0;
	
	$tok = strtok($cd_list, "_");
	while ($tok != false) {
	    $cd_array[$array_cnt] = $tok;
		$array_cnt++;
	    $tok = strtok("_");
	}
	
	$n_of_cd = count($cd_array);
	
	
	for($i=0;$i< $n_of_cd-1;$i++){
		$pre_cd_list = $pre_cd_list . "_" . $cd_array[$i] ;
	}
	
	
	$tpl->assign('cd_list', $cd_list);
	$tpl->assign('cd_array', $cd_array);
	$tpl->assign('cd', $cd);
	$tpl->assign('pre_cd_list', $pre_cd_list);
	
	//$unit_list_array
	$unit_list_array = array();
	for($i=0;$i<$n_of_cd;$i++){
		if($i==0){
			$unit_list_array[0] = "_" . $unit_array[0];
		}
		else{
			$unit_list_array[$i] = $unit_list_array[$i-1] . "_" . $unit_array[$i] ;
		}
	}
	$tpl->assign('unit_list_array',$unit_list_array);
	
	//$cd_list_array
	$cd_list_array = array();
	for($i=0;$i<$n_of_cd;$i++){
		if($i==0){
			$cd_list_array[0] = "_" . $cd_array[0];
		}
		else{
			$cd_list_array[$i] = $cd_list_array[$i-1] . "_" . $cd_array[$i] ;
		}
	}
	$tpl->assign('cd_list_array',$cd_list_array);
	
	//loop counter
	$cnt_arr = array(0,1,2);
	$tpl->assign('cnt_arr',$cnt_arr);
	
	
	//6/10 night new by lulu - end
	

	if($cd >= 0 && !empty($cd)){  //¦^¤W¤@¼hªº«ü¼Ð
		$sql = "SELECT * FROM lrtunit_basic_ WHERE unit_cd=$cd";
		$tmp = $DB_CONN->query($sql);
		while($record=$tmp->fetchRow(DB_FETCHMODE_ASSOC)){
			$tpl->assign('pre', $record["department"]);
		}
	}
	
	while($record=$result->fetchRow(DB_FETCHMODE_ASSOC)){ 
		$sql = "SELECT * FROM lrtunit_basic_ WHERE department=$record[unit_cd]"; //§ä´M¦³µL¤U¼h¥Ø¿ý
		$tmp = $DB_CONN->query($sql);
		if($tmp->numRows() == 0)
			$record['under'] = 0;
		else
			$record['under'] = 1;
			
		$tpl->append("Department", $record);

	}

	
	
	//6/10 new by lulu - start
	
	
	if($cd == null) //È¤ÕÆ¹Ý¨Æ˜à ½
		$sql = "SELECT * FROM begin_course WHERE begin_unit_cd = -1 ORDER BY begin_unit_cd";
	else
		$sql = "SELECT * FROM begin_course WHERE begin_unit_cd = '$cd' ORDER BY begin_unit_cd";
	
	$crs_list = $DB_CONN->query($sql);
	
	if( $record = $crs_list->fetchRow(DB_FETCHMODE_ASSOC) ){ //¦pªG¸Ó³æ¦ì¦³¶}³]½Òµ{
		$tpl->assign("have_course", 1);
		
		$tpl->append("course_data",$record);
		$num = 0;
		while( $record = $crs_list ->fetchRow(DB_FETCHMODE_ASSOC)){
			//æŸ¥å‡ºæŽˆèª²æ•™å¸«
			$sql = "SELECT p.personal_name FROM teach_begin_course tc, personal_basic p WHERE  tc.begin_course_cd='".$record[begin_course_cd]."' and tc.teacher_cd=p.personal_id";
			$res_tch = $DB_CONN->query($sql);
			if($res_tch->numRows()){//æœ‰æ•™å¸«
				while($tmp_row = $res_tch->fetchRow(DB_FETCHMODE_ASSOC)){
					$record['personal_name'] .= $tmp_row['personal_name']."<br>";
				}
			}
			else{// æ²’æ•™å¸«
				$record['personal_name'] = "<font color=red>æ•™å¸«æœªå®š</font>";
			}
			$record['num'] = $num++;
			
			$tpl->append("course_data",$record);
		}
	}
	
	
	//6/10 new by lulu - end
	
	assignTemplate($tpl, "/course_admin/list_unit.tpl");
	
?>
