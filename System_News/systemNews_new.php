<?php
/*
新增公告的儲存
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

$tpl = new Smarty;
$tpl->assign("imagePath", $IMAGE_PATH);

//用behavior的寫法來傳權限資料被猜到網址就被破解了，所以不使用了，直接使用session的role_cd
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

//incomingPage
$incomingPage = urlencode($_GET["incomingPage"]);
if(isset($incomingPage) == false)	$incomingPage = urlencode($_POST["incomingPage"]);
$tpl->assign("incomingPage", $incomingPage);

//finishPage
$finishPage = urlencode($_GET['finishPage']);					
if(isset($finishPage) == false)	$finishPage = urlencode($_POST["finishPage"]);
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
		$res = db_query($sql);
		
		if($res->numRows() == 0)	$isAllowPost = 0;
		if($res->numRows() > 0)
		{
			$rowCounter = 0;
			
			while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
			{
				if($rowCounter == 0)	$begin_course_cd = $row['begin_course_cd'];
				
				$courseList[$rowCounter] = 	array(
						"begin_course_cd" => $row['begin_course_cd'], 
						"courseName" => $row['begin_course_name']
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
		$res = db_query($sql);
		
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
				if($rowCounter == 0)	$begin_course_cd = $row['begin_course_cd'];
				
				$courseList[$rowCounter] = 
									array(
										"begin_course_cd" => $row['begin_course_cd'], 
										"courseName" => $row['begin_course_name']
										);
				$rowCounter++;
			}
			$tpl->assign("courseList", $courseList);
			$tpl->assign("begin_course_cd", $begin_course_cd);
			
		}
	}
}	

//判斷公告的類型(1.ㄧ般性 2.時限性 3.週期性)
$formType = optional_param('formType',1, PARAM_INT);
if( isset($formType) == false)	$formType = 1;
$tpl->assign("formType", $formType);

//重要等級
$tpl->assign("important", 1);

//年的範圍
$yearScopeStart = $SYSTEM_BEGIN_YEAR;
$yearScopeEnd = TIME_year() + 5;

$yearScopeCounter = 0;
for($counter = $yearScopeStart; $counter <= $yearScopeEnd; $counter++)
{
	$yearScope[$yearScopeCounter++] = $counter;
}
$tpl->assign("yearScope", $yearScope);

//開始日期
$tpl->assign("startYear", TIME_year());
$tpl->assign("startMonth", TIME_month());
$tpl->assign("startDay", TIME_day());

//結束日期
$tpl->assign("endYear", TIME_year());
$tpl->assign("endMonth", TIME_month());
$tpl->assign("endDay", TIME_day());

//週期日期
$tpl->assign("cycleYear", "0000");
$tpl->assign("cycleMonth", "00");
$tpl->assign("cycleDay", "00");
$tpl->assign("cycleWeek", "00");


$tpl->assign('news_course_types', $news_course_types) ;

//目前的Action
$tpl->assign("action", "new");

//目前的頁面
$tpl->assign("currentPage", "systemNews_new.php");

//Action的頁面
$tpl->assign("actionPage", "systemNews_newSave.php");

//Action結束後頁面
$tpl->assign("finishPage", $finishPage);

assignTemplate($tpl, "/system_news/systemNews_input.tpl");
?>
