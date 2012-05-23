<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/common.php");
	//update_status ( "觀看開課" );

	//new smarty
	checkAdminTeacherTa();
	$tpl = new Smarty();

	if(isset($_GET['begin_course_cd']))
	{
		$tpl->assign('begin_course_cd_tag',$_GET['begin_course_cd']);
	}

	if(array_key_exists('action', $_GET) && $_GET['action'] == "allow_course"){

		$sql = "UPDATE take_course SET allow_course='1',note='' WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_GET['personal_id'];
		$res = $DB_CONN->query($sql);
		sync_stu_course_data($_GET['begin_course_cd'],$_GET['personal_id']);
	}
	else if(array_key_exists('action', $_GET) && $_GET['action'] == "modify")
	{
		for($i = 0 ; $i < sizeof($_POST['check']) ; $i++)
		{

			if($_POST['flag']=='0')
			{
				$sql = "UPDATE take_course SET  allow_course='0', note='無' WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_POST['check'][$i];
				//$res = $DB_CONN->query($sql);
				//$sql = "UPDATE take_course SET allow_course='0' WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_POST['check'][$i];

			}
			else if($_POST['flag'] == '1')
			{
				$sql = "UPDATE take_course SET allow_course='1',note=null WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_POST['check'][$i];
			}
			$res = $DB_CONN->query($sql);
			sync_stu_course_data($_GET['begin_course_cd'],$_POST['check'][$i]);
		}
	}
	else if(array_key_exists('action', $_GET) && $_GET['action'] == "update_reason")
	{
		if(isset($_POST['note']))
		{
			if($_POST['note'] == '')
			{
				$reason = '無';
			}
			else
			{
				$reason = $_POST['note'];
			}
			$sql = "UPDATE take_course SET allow_course='0',note='".$reason."' WHERE begin_course_cd='".$_GET['begin_course_cd']."' and personal_id=".$_GET['personal_id'];
			$res = $DB_CONN->query($sql);
			sync_stu_course_data($_GET['begin_course_cd'],$_GET['personal_id']);
		}
	}


	$sql = "SELECT begin_course_name FROM begin_course WHERE begin_course_cd='". $_GET['begin_course_cd'] ."'";
	$begin_course_name = $DB_CONN->getOne($sql);
	$tpl->assign("begin_course_name", $begin_course_name);
	$tpl->assign("begin_course_cd", $_GET['begin_course_cd']);



	//列出修課學生
	$sql = "SELECT
				t.personal_id, t.allow_course, t.status_student, t.note, p.personal_name
			FROM
				take_course t, personal_basic p
			WHERE
				begin_course_cd='".$_GET['begin_course_cd']."'  and t.personal_id=p.personal_id";

	$res = $DB_CONN->query($sql);
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row['allow_course'] == 1)
			$row['allow'] = '核准';
		else if($row['note'] != '')
			$row['allow'] = '不核准';
		else
			$row['allow'] ='未審核';

		$tpl->append('stu_data', $row);
	}

	//輸出頁面
	assignTemplate($tpl, "/learner_profile/adm_check_select_course_stu.tpl");

//----------------function area ------------------
function degree($sel){
	$selDegree_names = array("未選", "專科" ,"大學" , "碩士", "博士", "榮譽博士");
	return $selDegree_names[$sel];
}

function dist($sel){
	$selDist_cd_names = array("未選", "老師" ,"學生" , "公務員");
	return $selDist_cd_names[$sel];
}


?>
