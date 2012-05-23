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
$teacher_cd = $personal_id;

$tpl = new Smarty;
$tpl->assign("imagePath", $IMAGE_PATH);
$tpl->assign("cssPath", $CSS_PATH);
$tpl->assign("absoluteURL", $absoluteURL);

$behavior == "teacher";
$tpl->assign("behavior", $behavior);

$tpl->assign("isNewOn", 1);		//是否允許新增公告
$tpl->assign("isModifyOn", 0);	//是否允許修改公告
$tpl->assign("isDeleteOn", 1);	//是否允許刪除公告

$tpl->assign("isShowCourse", 1);	//是否顯示課程

//是否顯示所有公告
$showAll = $_GET['showAll'];
if(isset($showAll) == false)	$showAll = 0;
$tpl->assign("showAll", $showAll);

//是否顯示RSS訂閱
$showRss = 1;
$tpl->assign("showRss", $showRss);
$tpl->assign("rssPage", "systemNews_teacher_rss.php?personal_id=$personal_id");

//搜尋所有課堂的公告
$sql = "SELECT A.*, B.course_type, D.begin_course_name " 
	." FROM news A, news_target B, teach_begin_course C, begin_course D "
	." WHERE C.teacher_cd = $teacher_cd AND C.begin_course_cd = B.begin_course_cd AND "
	." B.role_cd = 1 AND A.news_cd = B.news_cd AND C.begin_course_cd = D.begin_course_cd ORDER BY A.d_news_begin DESC, A.news_cd DESC";

$res = db_query($sql);


$newsNum = $res->numRows();
$tpl->assign("newsNum", $newsNum);

if($newsNum > 0)
{
	$$row_index = 0;
	
	while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
	{	

		//轉換公告時間，判斷是否為最新公告
		$date = convert_date($row['d_news_begin']) ;
		$new = (TIME_date(1) <= ($date + 2))?
			1:0;
		
		//3天內為最新公告
		if(TIME_date(1) <= ($date + 2))	$new = 1;
		else	$new = 0;
		
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
		
		
		$newsList[$row_index ++] = array(
			"news_cd" => $row['news_cd'],
			'course_type' => $row['course_type'],
			"date" => $date,
			"courseName" => $row['begin_course_name'], 
			"level" => convert_important($row['level']),
			"subject" => $row['subject'],
			"personal_name" => get_publish_name($row['personal_id']),
			"viewNum" => $row['frequency'],
			"new" => $new,
			"showContent" => ($row['content']==''?0:1),
			"content" => nl2br($row['content']),
			"file_list" => $file_list
		);
		
		if($showAll == 0 && $rowCounter == 10)	break;
	}
	
	$tpl->assign("newsShowNum", $rowCounter);
	well_print($newsList);
	echo "test";
	$tpl->assign("newsList", $newsList);
}

//目前的頁面
$tpl->assign("currentPage", "systemNews_teacherShowList.php");

//Action結束後的頁面
$tpl->assign("finishPage", "systemNews_teacherShowList.php");

assignTemplate($tpl, "/system_news/systemNews_showList.tpl");
?>