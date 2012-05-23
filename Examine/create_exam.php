<?php
/* author: lunsrot
 */
/*modify by lunsrot at 2007/03/21*/

//error_reporting(E_ALL);
require_once('../config.php');
require_once('../session.php');
/*modify end*/

require_once('../library/filter.php');

include('exam_info.php');
include('./library.php');

checkMenu('/Examine/create_exam.php');

global $DB_CONN;
$name = optional_param('name','');//$_GET['name'];
$type = optional_param('type',0,PARAM_INT);//$_GET['type'];
$score =optional_param('score',null);// $_GET['score'];
$tpl = new Smarty;

$attribute = get_course_attribute($_SESSION['begin_course_cd']);
$test_cnt = get_test_num($_SESSION['begin_course_cd']);

//echo "attribute".$attribute."<br/>test_cnt : ".$test_cnt."<br/>";

$tpl->assign('attribute',$attribute);
$tpl->assign('test_cnt',$test_cnt);
if($attribute==0 && $test_cnt >= 1)
{
    assignTempLate($tpl,"/examine/create_exam.tpl");
    //header('location:./exam_main.php');
    return;
}

if( empty($name) ){
	assignTemplate($tpl, "/examine/create_exam.tpl");
}else{
	checkExamine($name, $type, $score);

	if( $type == 1 ) 
		$score = 0;
	else if( empty($score) )		//這部份因為當初不懂事，和Ajax綁在一起，所以會有從$_SESSION中拿值的動作
		$score = $_SESSION['score'];
	session_unregister(score);

	$begin_course_cd = $_SESSION['begin_course_cd'];
	//檢查是否已有為該課程指定教材
	if( !selected_content($begin_course_cd) ){
		$tpl->assign("no_content", 1);
		assignTemplate($tpl, "/examine/create_exam.tpl");
		return;
	}
	db_query("insert into `test_course_setup` (begin_course_cd, test_type, test_name, percentage, is_online) values ($begin_course_cd, $type, '$name', $score, '1');");
	
	$result = db_query( "select test_no from `test_course_setup` where begin_course_cd=$begin_course_cd and test_name='$name';");
	$row = $result->fetchRow();
	$_SESSION['test_no'] = $row[0];

	//create成績項目，只有當測驗為正式測驗時新增
	if($type == 2){
		db_query("insert into `course_percentage` (begin_course_cd, percentage_type, percentage_num, percentage) values ($begin_course_cd, 1, $row[0], $score);");
	}else if($type == 1){
	  db_query("insert into `course_percentage` (begin_course_cd, percentage_type, percentage_num, percentage) values ($begin_course_cd, 1, $row[0], $score);");
	}
    
    //自學課程 直接設定時間為開放測驗 測驗完直接公布成績
    if($attribute == 0 ){    
        $sql="UPDATE test_course_setup 
              SET grade_public = 1 
              WHERE begin_course_cd = {$_SESSION['begin_course_cd']} AND 
              test_no = {$_SESSION['test_no']}";
        db_query($sql);
    }
	header("location:./exam_main.php");
}

/*library
 * 功能：確保測驗初始設定的值是合法的，若是不合法的會導向錯誤提示頁面
 * 參數：name是測驗名稱；type是測驗類型，分成計分與不計分；score是此次測驗配分
 * 回傳值：Null
 */
function checkExamine($name, $type, $score){
	
	//檢查名稱是否空白或重複
	if(empty($name))
		errorMsg("empty_name");
	$num = db_getOne("select count(*) from `test_course_setup` where begin_course_cd=$_SESSION[begin_course_cd] and test_name='$name';");
	if($num != 0)
		errorMsg("duplicate_name");

	//檢查是否有填寫配分或格式錯誤
	if($type == 2){
		if(empty($score))
			errorMsg("empty_percentage");
		if(!is_numeric($score) || $score < 0)
			errorMsg("error_percentage");
	}
}

/*library
 * 功能：題庫與教材有對應關係，故在新增測驗前需檢查該教師是否已選擇教材，而後才能從對應的題庫中挑選題目
 * 參數：begin_course_cd
 * 回傳值：是否有選擇教材
 */
function selected_content($begin_course_cd)
{
	$get_content_cd = " SELECT content_cd from class_content_current where begin_course_cd=$begin_course_cd";
	$result = db_query($get_content_cd);
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	
	if( empty($row['content_cd']) || $row['content_cd']== 0){
		return false;
	}
	return true;

}
function get_test_num($begin_course_cd)
{
    if(empty($begin_course_cd))
        return -1;
    return db_getOne("SELECT COUNT(*) FROM test_course_setup WHERE begin_course_cd={$begin_course_cd}");
}
function get_course_attribute($begin_course_cd)
{
    if(empty($begin_course_cd))
        return -1;
    return db_getOne("SELECT attribute FROM begin_course WHERE begin_course_cd={$begin_course_cd}");
}

?>
