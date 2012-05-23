<?php
/*
DATE:   2006/12/13
AUTHOR: 14_不太想玩
*/
$RELEATED_PATH = "../";

require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
require_once('library.php');
require_once($HOME_PATH.'library/filter.php');

$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;

$personal_id = $_SESSION['personal_id'];				//取得個人編號
$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程編號

$formType = $_POST['formType'];	

$tpl = new Smarty;
$tpl->assign("imagePath", $IMAGE_PATH);


//$behavior = $_GET['behavior'];					//取得行為
//if(isset($behavior) == false)	$behavior = $_POST["behavior"];
//$tpl->assign("behavior", $behavior);

$tpl->assign("isAllowPost", 1);		//是否允許發佈公告
$tpl->assign("isBackOn", 1);		//是否允許回上一頁

if($_SESSION['role_cd'] == 0)		//管理者
{
	$isShowCourse = 0;
	$tpl->assign("isShowCourse", $isShowCourse);
}
elseif($_SESSION['role_cd'] == 1 || $_SESSION['role_cd'] == 2)	//老師
{
	$isShowCourse = 1;
	$tpl->assign("isShowCourse", $isShowCourse);
}
else
{
	$isShowCourse = 0;
	$tpl->assign("isShowCourse", $isShowCourse);
}

//news_cd
$news_cd = required_param("news_cd",PARAM_INT) ;

$tpl->assign("news_cd", $news_cd);

//incomingPage
$incomingPage = $_GET["incomingPage"];
if(isset($incomingPage) == false)	$incomingPage = $_POST["incomingPage"];
$tpl->assign("incomingPage", $incomingPage);

//finishPage
$finishPage = $_GET['finishPage'];					
if(isset($finishPage) == false)	$finishPage = $_POST["finishPage"];
$tpl->assign("finishPage", $finishPage);

//回上一頁的參數
$tpl->assign("backArgument", "behavior=$behavior&finishPage=$finishPage");


//是否顯示單一課程
if($incomingPage == "systemNews_courseShowList.php"){	$onlyShowCurrentCourse = 1;}

//填入課程的資料	
if($isShowCourse == 1)
{
	if($onlyShowCurrentCourse == 1)
	{
		//到資料庫抓取本課程的課程名稱
		$sql = "SELECT 
					B.* 
				FROM 
					begin_course B 
				WHERE 
					B.begin_course_cd = $begin_course_cd
				";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		if($res->numRows() == 0)	$isAllowPost = 0;
		if($res->numRows() > 0)
		{
			$rowCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{
				if($rowCounter == 0)	$begin_course_cd = $row[begin_course_cd];
				
				$courseList[$rowCounter] = 
									array(
										"begin_course_cd" => $row[begin_course_cd], 
										"courseName" => $row[begin_course_name]
										);
				$rowCounter++;
			}
			$tpl->assign("courseList", $courseList);
			$tpl->assign("begin_course_cd", $begin_course_cd);
			
		}
	}
	else
	{
	
		//查看人員的角色
		$sql = "SELECT * FROM register_basic WHERE personal_id = $personal_id";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		$role_cd = $row['role_cd'];
	
		//到資料庫抓取所有的課程名稱
		$sql = "SELECT 
					B.* 
				FROM 
					teach_begin_course A, 
					begin_course B 
				WHERE 
					A.teacher_cd = $personal_id AND 
					A.begin_course_cd = B.begin_course_cd 
				ORDER BY 
					begin_course_cd ASC";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());
		
		if($res->numRows() == 0)	$isAllowPost = 0;
		if($res->numRows() > 0)
		{
			$rowCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{
				if($rowCounter == 0)	$begin_course_cd = $row[begin_course_cd];
				
				$courseList[$rowCounter] = 
									array(
										"begin_course_cd" => $row[begin_course_cd], 
										"courseName" => $row[begin_course_name]
										);
				$rowCounter++;
			}
			$tpl->assign("courseList", $courseList);
			$tpl->assign("begin_course_cd", $begin_course_cd);
			
		}
	}
}	


//從Table news取出資料
$res = db_query('SELECT * FROM news WHERE news_cd = ' . $news_cd);


$newsNum = $res->numRows();
if($newsNum > 0){

	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	
	if(isset($formType) == true)	$tpl->assign("formType", $formType);
	else							$tpl->assign("formType", $row['if_news']);
	
	$tpl->assign("important", $row[important]);
	
	//年的範圍
	$yearScopeStart = $SYSTEM_BEGIN_YEAR;
	$yearScopeEnd = TIME_year() + 5;
	
	$yearScopeCounter = 0;
	for($counter = $yearScopeStart; $counter <= $yearScopeEnd; $counter++)
	{
		$yearScope[$yearScopeCounter++] = $counter;
	}
	$tpl->assign("yearScope", $yearScope);
	
	//起始日期
	$d_news_begin = str_replace('-', '', $row[d_news_begin]); 
	$startYear = substr($d_news_begin, 0, 4);
	$startMonth = substr($d_news_begin, 4, 2);
	$startDay = substr($d_news_begin, 6, 2);
	
	$tpl->assign("startYear", $startYear);
	$tpl->assign("startMonth", $startMonth);
	$tpl->assign("startDay", $startDay);
	
	//結束日期
	$d_news_end = str_replace('-', '', $row[d_news_end]); 
	$endYear = substr($d_news_end, 0, 4);
	$endMonth = substr($d_news_end, 4, 2);
	$endDay = substr($d_news_end, 6, 2);
	
	$tpl->assign("endYear", $endYear);
	$tpl->assign("endMonth", $endMonth);
	$tpl->assign("endDay", $endDay);
	
	//週期日期
	$cycleYear = substr($row[d_cycle], 0, 4);
	$cycleMonth = substr($row[d_cycle], 4, 2);
	$cycleDay = substr($row[d_cycle], 6, 2);
	$cycleWeek = $row[week_cycle];
	
	$tpl->assign("cycleYear", $cycleYear);
	$tpl->assign("cycleMonth", $cycleMonth);
	$tpl->assign("cycleDay", $cycleDay);
	$tpl->assign("cycleWeek", $cycleWeek);
	
	$tpl->assign("subject", $row[subject]);
	$tpl->assign("content", $row[content]);
}

$sql_getNewsTarget = 'select course_type from news_target where news_cd='.$news_cd ; 
$news_course_types_selected = db_getOne($sql_getNewsTarget);

//從Table news_upload取出資料
$sql_getAllFiles = "SELECT * FROM news_upload WHERE news_cd =$news_cd ORDER BY file_cd ASC";
$file_list = db_getAll($sql_getAllFiles);

//幫file_url 加上WEBROOT 
if( !empty($file_list) ) {
	foreach($file_list as $key => &$row){
		if($row['if_url'] == 0) {// 如果是檔案
			$file_list[$key]['file_url'] = $WEBROOT . $row['file_url']; 
		}
	}
}
$tpl->assign("file_list", $file_list );

$tpl->assign("news_course_types", $news_course_types );
$tpl->assign("news_course_types_selected", $news_course_types_selected );

//目前的Action
$tpl->assign("action", "modify");

//目前的頁面
$tpl->assign("currentPage", "systemNews_modify.php");

//Action的頁面
$tpl->assign("actionPage", "systemNews_modifySave.php");

assignTemplate($tpl, "/system_news/systemNews_input.tpl");
?>
