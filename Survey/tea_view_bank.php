<?php
/*author: lunsrot
 * date: 2007/04/11
 */
require_once("../config.php");
require_once("../session.php");

checkMenu("/Survey/tea_view_bank.php");

//取出教師的問卷題庫編號，若該教師沒有問卷題庫則為他新增
$pid = getTeacherId();
$result = db_query("select survey_bankno from `survey_bank` where personal_id=$pid;");
if($result->numRows() == 0){
	db_query("insert into `survey_bank` (personal_id) values ($pid);");
	$result = db_query("select survey_bankno from `survey_bank` where personal_id=$pid;");
}
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$_SESSION['bank_no'] = $bankno = $row['survey_bankno'];

//瀏覽部份的呈現資料
$tpl = new Smarty;
$result = db_query("select survey_cd, question, survey_type from `survey_bank_question` where survey_bankno=$bankno and block_id=0 order by survey_cd;");
$node_id = 2;
$flag = true;
while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
	if($flag == true){
		$tpl->assign("first_block", $row['survey_cd']);
		$flag = false;
	}
	$row['index'] = $node_id++;
	$tpl->append("question_data", $row);
}

//新增部份的呈現
assignTemplate($tpl, "/survey/tea_view_bank.tpl");
?>
