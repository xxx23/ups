<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/date.php");
	
	//update_status ( "查詢所有課程" );
	
	
	// get personal id from session
	$pid = $_SESSION['personal_id'];
	//new smarty	
	$tpl = new Smarty();
	//取得選擇所有選課的課程id
	$sql = "SELECT a.begin_course_cd,a.allow_course,a.note FROM take_course a WHERE a.personal_id=$pid";	
	$result = $DB_CONN->query($sql);
	
	if($result->numRows())
	{
		//echo $result->numRows();
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			//取出課程資訊
			$sql = "SELECT 
				DISTINCT bc.begin_course_cd, bc.certify, bc.criteria_content_hour , bc.begin_course_name, bc.inner_course_cd, u.unit_name, bc.d_select_begin,
				  bc.d_select_end, bc.note , bc.attribute
			FROM 
				begin_course bc, lrtunit_basic_ u 
			WHERE 
				bc.begin_unit_cd=u.unit_cd  AND bc.begin_coursestate='1' AND bc.begin_course_cd=".$row['begin_course_cd'];
			
			$data_result = $DB_CONN->query($sql);
			if($data_result->numRows())
			{
				$data_row = $data_result->fetchRow(DB_FETCHMODE_ASSOC);
				//查出授課教師
				$sql = "SELECT p.personal_name,p.personal_id FROM teach_begin_course tc inner join personal_basic p on tc.teacher_cd=p.personal_id inner join register_basic r on p.personal_id = r.personal_id WHERE  tc.begin_course_cd='".$data_row['begin_course_cd']."' and r.role_cd = 1";
				$res_tch = $DB_CONN->query($sql);
				if($res_tch->numRows()){//有教師				
					while($tmp_row = $res_tch->fetchRow(DB_FETCHMODE_ASSOC)){
						$data_row['personal_name'] .= "<a href=\"".rtrim($WEBROOT,"/")."/Learner_Profile/queryTeacher.php?p=".$tmp_row['personal_id']."\" target=\"_blank\">".$tmp_row['personal_name']."</a><br/>";
					}
				}
				else{// 沒教師
					$data_row['personal_name'] = "<font color=red>教師未定</font>";
				}							
				//取得選課日期區間
				$data_row['select_date'] = 	substr($data_row['d_select_begin'],0,10) ."<br/>~<br/>" . substr($data_row['d_select_end'],0,10);	
				
				//assign 要輸出的變數
				if($row['allow_course'] == '1')//通過審核
				{
					$tpl->append('passExamineCourses',$data_row);
				}
				else if($row['note'] == null)//審核中
				{
					$tpl->append('examineCourses',$data_row);
				}
				else //未通過
				{
					$data_row['fail_reason'] = $row['note'];
					$tpl->append('failExamineCourses',$data_row);
				}
			}
		}
	}
	
	
	//輸出頁面
	assignTemplate($tpl, "/personal_page/select_course_result.tpl");
?>
