<?php
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
//error_reporting(E_All) ;
ini_set("display_errors","On");
$RELEATED_PATH = "../";

require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");

require_once('library.php');

$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
$absoluteURL = $HOMEURL . "System_News/";

$personal_id = $_SESSION['personal_id'];
$begin_course_cd = $_SESSION['begin_course_cd'];

$tpl = new Smarty;
$tpl->assign("imagePath", $IMAGE_PATH);
$tpl->assign("cssPath", $CSS_PATH);
$tpl->assign("absoluteURL", $absoluteURL);

//用behavior的寫法來傳權限資料被猜到網址就被破解了，所以不使用了，直接使用session的role_cd	
//$behavior = $_GET['behavior'];					//取得行為
//$tpl->assign("behavior", $behavior);

$displayType = $_GET['displayType'];			//取得顯示的狀態
$tpl->assign("displayType", $displayType);

if($_SESSION['role_cd'] == 1 || $_SESSION['role_cd'] == 2)
{
	$tpl->assign("isNewOn", 1);
	$tpl->assign("isModifyOn", 1);		
	$tpl->assign("isDeleteOn", 1);
	
	$isDisplayAll = 1;							//是否輸出所有公告
	
	$showRss = 1;								//是否顯示RSS
	$tpl->assign("showRss", $showRss);
}
elseif($_SESSION['role_cd'] == 3)
{
	$tpl->assign("isNewOn", 0);
	$tpl->assign("isModifyOn", 0);	
	$tpl->assign("isDeleteOn", 0);
	
	$isDisplayAll = 0;							//是否輸出所有公告
	
	$showRss = 1;								//是否顯示RSS
	$tpl->assign("showRss", $showRss);
}
else
{
	$tpl->assign("isNewOn", 0);
	$tpl->assign("isModifyOn", 0);	
	$tpl->assign("isDeleteOn", 0);
	
	$isDisplayAll = 0;							//是否輸出所有公告
	
	$showRss = 0;								//是否顯示RSS
	$tpl->assign("showRss", $showRss);
}

$finishPage = $_GET['finishPage'];					//取得動作結束後的網頁連結
$tpl->assign("finishPage", $finishPage);

//是否顯示所有公告
$showAll = $_GET['showAll'];
if(isset($showAll) == false)	$showAll = 0;
$tpl->assign("showAll", $showAll);

//是否顯示RSS訂閱
$tpl->assign("rssPage", "systemNews_course_rss.php?personal_id=$personal_id&begin_course_cd=$begin_course_cd");

		

//搜尋所有系統的公告
$get_allCourseNews ="SELECT A.* FROM news A, news_target B WHERE B.begin_course_cd=$begin_course_cd "
	."AND B.news_cd = A.news_cd ORDER BY A.d_news_begin DESC, A.news_cd DESC";
$res = db_query($get_allCourseNews);


$newsNum = $res->numRows();
$tpl->assign("newsNum", $newsNum);


if($newsNum > 0) {
	$rowCounter = 0;
	while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
	{	
		//公告編號
		$news_cd = $row['news_cd'];
		
		//公告標題
		$subject = $row['subject'];
        $subject = substr($subject,0,50);

		//公告po文者
		$personal_id = $row['personal_id'];
		$personal_name = get_publish_name($personal_id);

		//公告內容
		$content = $row['content'];
		if($row['content'] != "")	$showContent = 1;
		else					$showContent = 0;
		
		
				
		if($isDisplayAll == 0)
		{
			$type = $row[if_news];
			if($type == 2 || $type ==3)//時限性跟週期性公告
			{
				//判斷公告是否過期
				$endDate = str_replace('-', '', $row[d_news_end]); 
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
		}
		
		
		
		//處理date
		$date = str_replace('-', '', $row[d_news_begin]); 
		$date = substr($date, 0, 8);
		
		//判斷是否開始公告
		if($isDisplayAll == 0 && TIME_date(1) < $date)	continue;	//還未到公告日期
		
		//3天內為最新公告
		if(TIME_date(1) <= ($date + 2))	$new = 1;
		else	$new = 0;
		
		//處理important
		$level = convert_important($row['important'] );
		


		//觀看次數
		$viewNum = $row['frequency'];
		
		
		//從Table news_upload取出資料
		//從Table news_upload取出資料
		$get_upload_files = "SELECT * FROM news_upload WHERE news_cd="
		."{$row['news_cd']} ORDER BY file_cd ASC ";
		
		$upload_files = db_getAll($get_upload_files);
		

		unset($file_list);
		foreach($upload_files as &$each_file) {
			$file_list[] = array(
				"showFile" => ($each_file['if_url']==0?1:0),
				"showUrl" => ($each_file['if_url']==1?1:0),
				'file_name'=> $each_file['file_name'],
				'file_url'=> ($each_file['if_url']==1? 
					$each_file['file_url']:$WEBROOT.$each_file['file_url'])
			);

		}
		
		$newsList[$rowCounter] = array(
				"news_cd" => $news_cd, 
				"date" => $date, 
				"level" => $level, 
				"subject" => $subject, 
				"personal_name" => $personal_name,
				"viewNum" => $viewNum, 
				"new" => $new, 
				"showContent" => $showContent, 
				"content" => nl2br($content), 
				"file_list" => $file_list
			);
			
		$rowCounter++;
		if($showAll == 0 && $rowCounter == 10)	break;
	}
	$tpl->assign("newsShowNum", $rowCounter);
	$tpl->assign("newsList", $newsList);
}


//目前的頁面
$tpl->assign("currentPage", "systemNews_courseShowList.php");
$tpl->assign("show_title" , "0"); //課程公告

assignTemplate($tpl, "/system_news/systemNews_courseShowList.tpl");


?>
