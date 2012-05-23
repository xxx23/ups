<?php
/********************************************************/
/* id: course_tracking.php 2009/7/30 by q110185         */
/* function: 傳入begin_course_cd 輸出教材瀏覽狀況樹狀圖	*/
/********************************************************/

include "../config.php";
require_once("../session.php");
require_once("../library/common.php");
require_once("../Learning_Tracking/time_output_format.php");
//require_once("./lib/textbook_func.inc");

//checkMenu("/Learning_Tracking/showAllStudentCourseUseLog.php");

//$Begin_course_cd = $_SESSION['begin_course_cd'];
//$Personal_id = $_GET['personal_id'];

//取得課程cd
$Begin_course_cd = $_GET['begin_course_cd'];

//取得本課程所用的教材編號
$sql = "select content_cd from class_content_current where begin_course_cd = '$Begin_course_cd'";
$Content_cd = db_getOne($sql);


$AddNode = buildTreeStructure($Content_cd, $Begin_course_cd);
//print $AddNode;
//因為存進DB中的各個node，其url都為呼叫tea_textbook_content.php，但student進入時必須處理stu_textbook_content.php
//故將"tea_"替換為"stu_"

$smtpl = new Smarty;
$Script_path = $WEBROOT.$JAVASCRIPT_PATH.'tiny_mce/tiny_mce.js';
$smtpl->assign("script_path",$Script_path);

$smtpl->assign("addNode",$AddNode); //build tree
$smtpl->assign("Content_cd",$Content_cd);	//assign "課程科目教材編號" for inserting node

if ( is_scorm($Content_cd) ){
    $IS_SCORM= true;
}else{
    $IS_SCORM= false;
}
$smtpl->assign("IS_SCORM",$IS_SCORM);
assignTemplate($smtpl,"/teaching_material/course_tracking.tpl");

function is_scorm($Content_cd){
    $sql = "select content_cd from mdl_scorm where content_cd = '$Content_cd'";
    $content_cd = db_getOne($sql);
    if(!empty($content_cd))
    { 
        return true;
    }
    else
    {
        return false;
    }
}
function buildTreeStructure($Content_cd, $Begin_course_cd) {
	global $Begin_course_cd,$WEBROOT;
	$sql = "select * from class_content where content_cd = '$Content_cd' order by cast(menu_parentid as unsigned),seq asc;";
	$result = db_query($sql);


 	$t = "";
	$r = "";
  	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
//echo "<pre>";		
//var_dump($row);
//echo "</per>";
	$status_str = learning_status_str($Content_cd,$row['menu_id'], $Begin_course_cd);
	if($row['menu_parentid'] == 0){
		$r .= "tree.setNodeCtxMenu(".$row['menu_id'].",ctx2);\n";  //設定根節點disable menu，檔名取ctx2才不會有問題...@@
		$t .= "tree.add(\"" . $row['menu_id'] . "\", " .
   	  	"\"" . $row['menu_parentid'] . "\", " .
      		"\"" . $row['caption'] . "\", " .
      		"\"" . "" . "\", " .
      		"\"" . $row['icon'] . "\", " .
      		$row['exp'] . ", " .
   	  	"false " .
      		");\n";
	}
	else{
   		$t .= "tree.add(\"" . $row['menu_id'] . "\", " .
   	  	"\"" . $row['menu_parentid'] . "\", " .
      		"\"" . $row['caption']."        ".$status_str . "\", " .
      		"\"" . "" . "\", " .
      		"\"" . $WEBROOT. ltrim(ltrim($row['icon']),"/") . "\", " .
      		$row['exp'] . ", " .
   	  	"false " .
      		");\n";
    	}
	}
	
	/*if(empty($t))
		$t = "tree.add(1, 0, \"目前沒有任何資料\", \"\", \"\", true);";
	*/
	return $t.$r;
}

function learning_status_str($Content_cd,$Menu_id, $Begin_course_cd)
{

	//$sql = "select * from student_learning 
	//	where begin_course_cd = '$Begin_course_cd' and personal_id = '$Personal_id' and menu_id = '$Menu_id'";
	$sql = "select SUM(event_happen_number) AS event_happen_number_sum,
				   SUM(TIME_TO_SEC(event_hold_time)) AS event_hold_time_sum
			from student_learning 
			where begin_course_cd = '$Begin_course_cd' and content_cd='".$Content_cd."' and menu_id = '$Menu_id'";
	//echo $sql;
	$result = db_query($sql);
	
	//print_r($result);
	//print $result->numRows();
	if($result->numRows())
	{
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		//print $row['event_happen_number'];
		//print_r($row);
		$total_happen_num = ($row['event_happen_number_sum'])?$row['event_happen_number_sum']:0;
		$total_hold_time =  ($row['event_hold_time_sum'])? $row['event_hold_time_sum']:0;
		if($total_happen_num==0 && $total_hold_time==0)
			$str = "------- [未曾點閱]";
		else{
		  $total_hold_time = time_output_format($total_hold_time);
		  
		  $str = "------- [ 點閱".$total_happen_num. "次  |  停留總時間：" . $total_hold_time. " ]";//------[ 首次登入時間：".$row['event_occur_time'] . "  |  上次登入時間：". $row['event_last_time']. " ]";
			
		}
		return $str;
	}
	else
		return "------- [未曾點閱]";
}
?>
