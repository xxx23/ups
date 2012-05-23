<?
/*
DATE:   2007/07/19
AUTHOR: 14_���ӷQ��
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Certificate/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//���o�ӤH�s��
	$role_cd = $_SESSION['role_cd'];					//���o����
	$begin_course_cd = $_GET['begin_course_cd'];		//���o�ҵ{�s��

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("begin_course_cd", $begin_course_cd);

	$credential_type_cd = 1;
	
	$action = "new";									//�ثe��Action									
	
	//�qTable credential_type���X���
	$sql = "SELECT 
				* 
			FROM 
				credential_type 
			WHERE 
				credential_type_cd=$credential_type_cd AND 
				begin_course_no=$begin_course_cd
			";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	
	if($resultNum <= 0)
	{
		$tpl->assign("isUsebackgroundFile", 0);		//�O�_�ϥίB���L
	}
	elseif($resultNum > 0)
	{
		$action = "modify";
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$sash_template_no = $row[sash_template_no];
		$emboss_no2 = $row[emboss_no2];
		
		$tpl->assign("outerFile", $sash_template_no);
		
		//�O�_�ϥίB���L
		if($emboss_no2 != "")	$tpl->assign("isUsebackgroundFile", 1);
		else					$tpl->assign("isUsebackgroundFile", 0);
		$tpl->assign("backgroundFile", $emboss_no2);
		
		
		//�qTable credential_content���X���
		$sql = "SELECT 
					* 
				FROM 
					credential_content 
				WHERE 
					credential_type_cd=$credential_type_cd AND 
					begin_course_no=$begin_course_cd
				ORDER BY 
					seq_no ASC
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$resultNum = $res->numRows();
		
		if($resultNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$content1 = $row[content];
			$tpl->assign("content1", $content1);
			
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$content2 = $row[content];
			$tpl->assign("content2", $content2);
			
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$content3 = $row[content];
			$tpl->assign("content3", $content3);
		}
	}
	
	
	
	//��X�ثe��action
	$tpl->assign("action", $action);
	

	//�ثe������
	$tpl->assign("currentPage", "setupCourseGradeReport.php");
	
	assignTemplate($tpl, "/certificate/certificateInput.tpl");
?>
