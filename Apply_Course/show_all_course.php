<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq


**/
	require_once("../config.php");
	//new smarty
	$tpl = new Smarty();
	
	//搜尋
	if($_GET['search'] == 'yes'){
		$tpl->assign("show_search", "1");
		
		for($i=0; $i < count($_GET['query']); $i++){
			if($_GET['query'][$i]==0){
				$sql = "SELECT * FROM course_basic ORDER BY course_cd ASC";
			}
			else{
				//$sql = "SELECT * FROM course_basic WHERE";
				if($_GET['query'][$i] == 1)
					$sql = "SELECT * FROM course_basic WHERE course_name like '%".$_GET['name_input']."%'";
				if($_GET['query'][$i] == 2)
					$sql = "SELECT * FROM course_basic WHERE course_classify_cd='".$_GET['cd_input']."'";
				if($_GET['query'][$i] == 3)
					$sql = "SELECT * FROM course_basic WHERE course_classify_parent='".$_GET['parent_input']."'";
			}			
		}
		
		$result = $DB_CONN->query($sql);
		$num = 0;
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$row['num'] = $num++;
			$tpl->append('course_data', $row);
		}		
		
	}
	
	//輸出頁面

	$tpl->display("show_all_course.tpl");	
	
?>