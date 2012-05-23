<?php
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
$RELEATED_PATH = "../";

require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");

require_once("library.php");
$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
$absoluteURL = $HOMEURL . "System_News/";

$personal_id = $_SESSION['personal_id'];
$student_cd = $personal_id;

$behavior == "student";
$tpl->assign("behavior", $behavior);

$tpl = new Smarty;
$tpl->assign("imagePath", $IMAGE_PATH);
$tpl->assign("cssPath", $CSS_PATH);
$tpl->assign("absoluteURL", $absoluteURL);

$tpl->assign("isShowCourse", 1);	//是否顯示課程

//是否顯示所有公告
$showAll = $_GET['showAll'];
if(isset($showAll) == false)	$showAll = 0;
$tpl->assign("showAll", $showAll);

//是否顯示RSS訂閱
$showRss = 1;
$tpl->assign("showRss", $showRss);
$tpl->assign("rssPage", "systemNews_student_rss.php?personal_id=$personal_id");

//搜尋所有課堂的公告
$sql = "SELECT A.*,B.course_type, D.begin_course_name FROM news A, news_target B, take_course C, begin_course D WHERE C.personal_id = (?) AND C.begin_course_cd = B.begin_course_cd AND B.role_cd = 01 AND A.news_cd = B.news_cd AND C.begin_course_cd = D.begin_course_cd ORDER BY A.d_news_begin DESC, A.news_cd DESC";
$data = array($personal_id);
$res = db_query($sql, $data);


$newsNum = $res->numRows();
$tpl->assign("newsNum", $newsNum);

if($newsNum > 0){
	$rowCounter = 0;
	
	while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
	{	
		//公告編號
		$news_cd = $row[news_cd];
		
		//公告標題
		$subject = $row[subject];
        $subject = substr($subject,0,50);
			
		//取得po文者名字
		$personal_id = $row[personal_id];
		$personal_name = get_publish_name($personal_id);

		//公告內容
		$content = $row[content];
		if($row[content] != "")	$showContent = 1;
		else					$showContent = 0;
		
		//課程名稱
		$courseName = $row[begin_course_name];
		
		$type = $row[if_news];
		if($type == 2 || $type ==3)//時限性跟週期性公告
		{
			//判斷公告是否過期
			$endDate = str_replace('-', '', $row['d_news_end']); 
			$endDate = substr($endDate, 0, 8);

			//公告已經過期
			if(TIME_date(1) > $endDate)	continue;
		}
		if($type == 3)//週期性公告
		{
			//year
			$cycleYear = substr($row[d_cycle], 0, 4);
			if($cycleYear != '0000' && $cycleYear != TIME_year())	continue;
			
			//month
			$cycleMonth = substr($row[d_cycle], 4, 2);
			if($cycleMonth != '00' && $cycleMonth != TIME_month())	continue;

			//day
			$cycleDay = substr($row[d_cycle], 6, 2);
			if($cycleDay != '00' && $cycleDay != TIME_day())	continue;

			//week
			$cycleWeek = $row[week_cycle];
			if($cycleWeek != '00' && $cycleWeek != TIME_week())	continue;
		}
		
		//處理date
		$date = str_replace('-', '', $row[d_news_begin]); 
		$date = substr($date, 0, 8);
		
		//判斷是否開始公告
		if(TIME_date(1) < $date)	continue;	//還未到公告日期
		
		//3天內為最新公告
		if(TIME_date(1) <= ($date + 2))	$new = 1;
		else	$new = 0;
		
		//處理important
		if($row[important] == 0)	$level = "最低";
		else if($row[important] == 1)	$level = "中等";
		else if($row[important] == 2)	$level = "最高";
		else	$level = "其它等級";

		//觀看次數
		$viewNum = $row[frequency];
		
		
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
		
		$newsList[$rowCounter] = array(
							"news_cd" => $news_cd, 
							"date" => $date, 
							"courseName" => $courseName, 
							"level" => $level, 
							"subject" => $subject, 
															"personal_name" => $personal_name,
							"viewNum" => $viewNum, 
							"new" => $new, 
							"showContent" => $showContent, 
							"content" => nl2br($content), 
							"showFile" => $showFile, 
							"fileName" => $fileName, 
							"fileUrl" => $fileUrl, 
							"showUrl" => $showUrl, 
							"url" => $url);
		
		$rowCounter++;
		if($showAll == 0 && $rowCounter == 10)	break;
	}
	$tpl->assign("newsShowNum", $rowCounter);
	$tpl->assign("newsList", $newsList);
}

//目前的頁面
$tpl->assign("currentPage", "systemNews_studentShowList.php");

//Action結束後的頁面
$tpl->assign("finishPage", "systemNews_studentShowList.php");

assignTemplate($tpl, "/system_news/systemNews_showList.tpl");
?>
