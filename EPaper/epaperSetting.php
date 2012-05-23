<?
/*
DATE:   2007/04/10
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";	


	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	
	if($role_cd == 0)//系統管理者
	{
		$begin_course_cd = -1;
	}
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	//從Table e_paper判斷是否有課程電子報
	$sql = "SELECT * FROM e_paper 
					WHERE 
						begin_course_no=$begin_course_cd";
	$res = $DB_CONN->query($sql);
	if(PEAR::isError($res))	die($res->getMessage());
	
	$classEPaperNum = $res->numRows();
	if($classEPaperNum == 0)
	{
		//從Table e_paper取得新的periodical_cd期刊編號
		$sql = "SELECT * FROM e_paper WHERE begin_course_no=$begin_course_cd ORDER BY periodical_cd DESC";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
	
		$periodicalNum = $res->numRows();
		if($periodicalNum == 0)
		{
			$periodical_cd = 1;
		}
		else
		{	
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$periodical_cd = $row[periodical_cd] + 1;
		}
		//echo $periodical_cd;//for test
		
		
		//從Table e_paper取得新的epaper_cd電子報編號
		$sql = "SELECT * FROM e_paper ORDER BY epaper_cd DESC";
		$res = $DB_CONN->query($sql);
		if(PEAR::isError($res))	die($res->getMessage());
	
		$epaperNum = $res->numRows();
		if($epaperNum == 0)
		{
			$epaper_cd = 1;
		}
		else
		{	
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
			$epaper_cd = $row[epaper_cd] + 1;
		}
		//echo $epaper_cd;//for test
		
		
		//新增課程電子報設定
		$d_public_day = TIME_date(1) . TIME_time(1);
		$if_auto = "Y";
		$sql = "INSERT INTO e_paper 
							(
								epaper_cd, 
								periodical_cd, 
								begin_course_no, 
								d_public_day, 
								if_auto
							) VALUES (
								$epaper_cd, 
								$periodical_cd,
								$begin_course_cd, 
								$d_public_day, 
								'$if_auto'
							)";
		$sth = $DB_CONN->prepare($sql);
		$res = $DB_CONN->execute($sth);
		if (PEAR::isError($res))	die($res->getMessage());
	}
	else
	{	
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
		$epaper_cd = $row[epaper_cd];
		$if_auto = $row[if_auto];
	}
	//echo $epaper_cd;//for test
	
	
	//輸出epaper_cd
	$tpl->assign("epaper_cd", $epaper_cd);
	
	
	//輸出是否自動發送
	$tpl->assign("if_auto", $if_auto);
	
	assignTemplate($tpl, "/epaper/epaperSetting.tpl");
?>