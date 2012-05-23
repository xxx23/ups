<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../config.php");
require_once("../session.php");
include "sur_info.php";

checkMenu("/Survey/tea_view_bank.php");

$tpl = new Smarty;

$block = $_GET['block_id'];
$survey_cd = $_GET['survey_cd'];
$bankno = $_SESSION['bank_no'];

$result = $DB_CONN->getRow("select * from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$survey_cd;", DB_FETCHMODE_ASSOC);
display_edit($tpl, $block, $result);

assignTemplate($tpl, "/survey/tea_view_edit.tpl");

function display_edit($tpl, $block, $result){
	$tpl->assign("block_id", $block);
	$tpl->assign("content", $result['question']);
	$tpl->assign("survey_cd", $result['survey_cd']);
	$tpl->assign("option", "update_question");

	$tpl->assign("survey_type", array(1 => "選擇題", 2 => "簡答題"));
	$tpl->assign("type_select", $result['survey_type']);

	$tpl->assign("survey_no", array(2 => "二個選項", 3 => "三個選項", 4 => "四個選項", 5 => "五個選項", 6 => "六個選項"));
	$tpl->assign("no_select", $result['selection_no']);

	$tpl->assign("is_multiple", array(0 => "單選", 1 => "複選"));
	$tpl->assign("multi_select", $result['is_multiple']);

	$num = array("一", "二", "三", "四", "五", "六");
	for($i = 0 ; $i < 6 ; $i++){
		$string['num'] = $num[$i];
		$string['content'] = $result["selection" . ($i+1)];
		$tpl->append("strings", $string);
	}
}
?>
