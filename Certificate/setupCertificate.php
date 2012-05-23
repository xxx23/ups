<?
/*
DATE:   2007/07/19
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Certificate/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程編號

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	$tpl->assign("begin_course_cd", $begin_course_cd);

	$credential_type_cd = 1;
	
	$action = "new";									//目前的Action									
	
	//從Table credential_type取出資料
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
		$tpl->assign("isUsebackgroundFile", 0);		//是否使用浮水印
	}
	elseif($resultNum > 0)
	{
		$action = "modify";
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);

		$sash_template_no = $row[sash_template_no];
		$emboss_no2 = $row[emboss_no2];
		
		$tpl->assign("outerFile", $sash_template_no);
		
		//是否使用浮水印
		if($emboss_no2 != "")	$tpl->assign("isUsebackgroundFile", 1);
		else					$tpl->assign("isUsebackgroundFile", 0);
		$tpl->assign("backgroundFile", $emboss_no2);
		
		
		//從Table credential_content取出資料
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
	
	
	
	//輸出目前的action
	$tpl->assign("action", $action);
	

	//目前的頁面
	$tpl->assign("currentPage", "setupCourseGradeReport.php");
	
	assignTemplate($tpl, "/certificate/certificateInput.tpl");
?>
