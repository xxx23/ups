<?
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	
	require_once("library.php");
	require_once("../library/account.php");

	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH . $CSS_VERSION_PATH;
	$absoluteURL = $HOMEURL . "System_News/";
	
	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);
	
	session_start();
	$template = db_getOne("SELECT course_style FROM `personal_basic` WHERE personal_id=$_SESSION[personal_id];");
	if(empty($template))
		$template = get_style($_SESSION['personal_id'], "course_style");
	$_SESSION['template'] = $template;

	//取得所有參數
	$argument = $_GET['argument'];
	
	$news_cd = strtok($argument, "_");	//取得news_cd
		
		
	$personal_id = strtok("_");	//取得personal_id
	if($personal_id == "")	$personal_id = -1;
	
	$isShowCourse = strtok("_");	//取得isShowCourse
	if($isShowCourse == "")	$isShowCourse = 0;;
	$tpl->assign("isShowCourse", $isShowCourse);

	//從Table news取出資料
	if($isShowCourse == 0)
	{
		$sql = "SELECT * FROM news WHERE news_cd = $news_cd";
	}
	else
	{
		$sql = "SELECT A.*, C.begin_course_name FROM news A, news_target B, begin_course C WHERE A.news_cd=$news_cd AND A.news_cd=B.news_cd AND B.begin_course_cd=C.begin_course_cd";
	}
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());

	$newsNum = $res->numRows();
	if($newsNum > 0)
	{
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		
		//公告編號
		$news_cd = $row[news_cd];
			
		//公告標題
		$subject = $row[subject];

		//公告發佈者
		$personal_id = $row['personal_id'];
		$personal_name = get_publish_name($personal_id);
			
		//公告內容
		$content = $row[content];
		if($row[content] != "")	$showContent = 1;
		else					$showContent = 0;	
		
		//課程名稱
		$courseName = $row[begin_course_name];
		
		//處理date
		$date = str_replace('-', '', $row[d_news_begin]); 
		$date = substr($date, 0, 8);	
		
		//處理important
		if($row[important] == 0)	$level = "最低";
		else if($row[important] == 1)	$level = "中等";
		else if($row[important] == 2)	$level = "最高";
		else	$level = "其它等級";		
		
		
		//瀏覽的次數
		$viewNum = $row[frequency]+1;
		
		//增加瀏覽的次數
		$sth = $DB_CONN->prepare("UPDATE news SET frequency = (?) WHERE news_cd = (?)");
		$data = array($viewNum, $news_cd);
		$res = $DB_CONN->execute($sth, $data);
		if (PEAR::isError($res))	die($res->getMessage());
		
		//從Table news_upload取出資料
		$resContent = $DB_CONN->query("SELECT * FROM news_upload WHERE news_cd = $news_cd ORDER BY file_cd ASC");
		if (PEAR::isError($resContent))	die($resContent->getMessage());

		$newsContentNum = $resContent->numRows();
		if($newsContentNum > 0)
		{
			while($resContent->fetchInto($rowContent, DB_FETCHMODE_ASSOC))
			{
				if($rowContent[if_url] == 0)//檔案
				{
					$showFile = 1;
					$fileName = $rowContent[file_name];
					
					//設定檔案路徑
					$fileUrl = $rowContent[file_url];
					$tmp_fileUrl = $fileUrl;	
					$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
					$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
					$tmp_fileUrl = substr($tmp_fileUrl, 0, strrpos($tmp_fileUrl, "/"));
					$fileUrl = $RELEATED_PATH . substr($fileUrl, strrpos($tmp_fileUrl, "/")+1, strlen($fileUrl));
					
				}
				else if($rowContent[if_url] == 1)//網址
				{
					$showUrl = 1;
					$url = $rowContent[file_url];
				}
			}
		}
		
		$newsList[0] = array(
						"news_cd" => $news_cd, 
						"date" => $date, 
						"courseName" => $courseName, 
						"personal_name" => $personal_name,
						"level" => $level, 
						"subject" => $subject, 
						"viewNum" => $viewNum, 
						"new" => $new, 
						"showContent" => $showContent, 
						"content" => nl2br($content), 
						"showFile" => $showFile, 
						"fileName" => $fileName, 
						"fileUrl" => $fileUrl, 
						"showUrl" => $showUrl, 
						"url" => $url);
	}
	$tpl->assign("newsShowNum", 1);
	$tpl->assign("newsList", $newsList);

	assignTemplate($tpl, "/system_news/systemNews_show.tpl");
?>