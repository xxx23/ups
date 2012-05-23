<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../config.php");
require_once("../session.php");

$block = $_GET['block_id'];
if($block <= 0){
	header("location:manual.php");
	exit(0);
}
$bankno = $_SESSION['bank_no'];
$tpl = new Smarty;

$appear = $_GET['appear'];
if(empty($appear))
	$appear = "view";
$tpl->assign("appear", $appear);
$tpl->assign("reload", $_GET['reload']);

//有關題目更新的部份
display_edit($tpl, $block);
$tpl->assign("option", "create");

//有關瀏覽所有題目的部份
$result = db_query("select survey_cd, survey_type, question from `survey_bank_question` where survey_bankno=$bankno and block_id=$block;");
$num = $result->numRows();
$tpl->assign("num", $num);
$i = 1;
$string = Array("", "選擇題", "問答題");
while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	$row['num'] = $i;
	$row['survey_type'] = $string[ $row['survey_type'] ];
	$row['block_id'] = $block;
	$tpl->append("question", $row);
	$i++;
}

assignTemplate($tpl, "/survey/question_list.tpl");

function display_edit($tpl, $block){
	$tpl->assign("block_id", $block);

	$tpl->assign("survey_type", array(1 => "選擇題", 2 => "簡答題"));
	$tpl->assign("type_select", 1);

	$tpl->assign("survey_no", array(2 => "二個選項", 3 => "三個選項", 4 => "四個選項", 5 => "五個選項", 6 => "六個選項"));
	$tpl->assign("no_select", 2);

	$tpl->assign("is_multiple", array(0 => "單選", 1 => "複選"));
	$tpl->assign("multi_select", 0);

	$num = array("一", "二", "三", "四", "五", "六");
	for($i = 0 ; $i < 6 ; $i++){
		$string['num'] = $num[$i];
		$string['content'] = "";
		$tpl->append("strings", $string);
	}
}
?>
