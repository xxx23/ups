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
	
	//update_status ( "�d�ߩҦ��ҵ{" );
	
	
	// get personal id from session
	$pid = $_SESSION['personal_id'];
	//new smarty	
	$tpl = new Smarty();
	//���o��ܩҦ���Ҫ��ҵ{id
	$sql = "SELECT a.begin_course_cd,a.allow_course,a.note FROM take_course a WHERE a.personal_id=$pid";	
	$result = $DB_CONN->query($sql);
	
	if($result->numRows())
	{
		//echo $result->numRows();
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			//���X�ҵ{��T
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
				//�d�X�½ұЮv
				$sql = "SELECT p.personal_name,p.personal_id FROM teach_begin_course tc inner join personal_basic p on tc.teacher_cd=p.personal_id inner join register_basic r on p.personal_id = r.personal_id WHERE  tc.begin_course_cd='".$data_row['begin_course_cd']."' and r.role_cd = 1";
				$res_tch = $DB_CONN->query($sql);
				if($res_tch->numRows()){//���Юv				
					while($tmp_row = $res_tch->fetchRow(DB_FETCHMODE_ASSOC)){
						$data_row['personal_name'] .= "<a href=\"".rtrim($WEBROOT,"/")."/Learner_Profile/queryTeacher.php?p=".$tmp_row['personal_id']."\" target=\"_blank\">".$tmp_row['personal_name']."</a><br/>";
					}
				}
				else{// �S�Юv
					$data_row['personal_name'] = "<font color=red>�Юv���w</font>";
				}							
				//���o��Ҥ���϶�
				$data_row['select_date'] = 	substr($data_row['d_select_begin'],0,10) ."<br/>~<br/>" . substr($data_row['d_select_end'],0,10);	
				
				//assign �n��X���ܼ�
				if($row['allow_course'] == '1')//�q�L�f��
				{
					$tpl->append('passExamineCourses',$data_row);
				}
				else if($row['note'] == null)//�f�֤�
				{
					$tpl->append('examineCourses',$data_row);
				}
				else //���q�L
				{
					$data_row['fail_reason'] = $row['note'];
					$tpl->append('failExamineCourses',$data_row);
				}
			}
		}
	}
	
	
	//��X����
	assignTemplate($tpl, "/personal_page/select_course_result.tpl");
?>
