<?
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";

	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$fileDirectory = "file/";
	
	$news_cd = $_GET['news_cd'];
	if(isset($news_cd) == false)	$news_cd = $_POST['news_cd'];

	//$behavior = $_GET['behavior'];					//取得行為
	//if(isset($behavior) == false)	$behavior = $_POST["behavior"];

	//incomingPage
	$incomingPage = $_GET["incomingPage"];
	if(isset($incomingPage) == false)	$incomingPage = $_POST["incomingPage"];
	
	//finishPage
	$finishPage = $_GET['finishPage'];					
	if(isset($finishPage) == false)	$finishPage = $_POST["finishPage"];
	
	//先隨便加一下安全性考量，但不同課的老師還是可以用網址互刪 by tkraha
	if($_SESSION['role_cd'] != 0 && $_SESSION['role_cd'] != 1 && $_SESSION['role_cd'] != 2)
		exit;
	

	$sql = "SELECT * FROM news WHERE news_cd = $news_cd";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$newsNum = $res->numRows();

	if($newsNum > 0)
	{
		//取得news_cd
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$news_cd = $row[news_cd];
		
		//判斷是否有上傳檔案在伺服器
		$sql = "SELECT * FROM news_upload WHERE news_cd = (?) AND if_url = (?)";
		$data = array($news_cd, 0);
		$sth = $DB_CONN->prepare($sql);	
		$res = $DB_CONN->execute($sth, $data);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$newsNum = $res->numRows();
		if($newsNum > 0)
		{
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			$fileName = $row[file_url];

			//刪除檔案
			@unlink($fileName);
		}
		
		//從Table news_upload中刪除資料
		$sql = "DELETE FROM news_upload WHERE news_cd = (?)";
		$data = array($news_cd);
		$sth = $DB_CONN->prepare($sql);	
		$res = $DB_CONN->execute($sth, $data);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table news_target中刪除資料
		$sql = "DELETE FROM news_target WHERE news_cd = (?)";
		$data = array($news_cd);
		$sth = $DB_CONN->prepare($sql);	
		$res = $DB_CONN->execute($sth, $data);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table news中刪除資料
		$sql = "DELETE FROM news WHERE news_cd = (?)";
		$data = array($news_cd);
		$sth = $DB_CONN->prepare($sql);		
		$res = $DB_CONN->execute($sth, $data);
		if (PEAR::isError($res))	die($res->getMessage());
	}

	header("location: $finishPage");
?>
