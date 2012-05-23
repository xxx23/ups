<?
/*
DATE:   2007/04/03
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$absoluteURL = $HOMEURL . "EPaper/";

	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼


	$behavior = $_GET["behavior"];
	if( isset($behavior) == false)	$behavior = $_POST["behavior"];

	$epaper_cd = $_GET["epaper_cd"];
	if( isset($epaper_cd) == false)	$epaper_cd = $_POST["epaper_cd"];
	
	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";
	
	
	//刪除電子報檔案
	$sql = "SELECT * FROM e_paper WHERE epaper_cd=$epaper_cd";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		$fileName = $row[epaper_file_url];
		
		//刪除檔案
		@unlink($FILE_PATH . $fileName);
	}
	
	//從Table course_epaper中刪除資料
	$sql = "DELETE FROM course_epaper WHERE epaper_cd=$epaper_cd";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	
	//從Table e_paper中刪除資料
	$sql = "DELETE FROM e_paper WHERE epaper_cd=$epaper_cd";
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	header("Location: epaperList.php?behavior=$behavior")
?>
