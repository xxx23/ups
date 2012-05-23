<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../config.php");
require_once("../session.php");

$survey_cd = $_POST['survey_cd'];
$s_type = $_POST['s_type'];
$question = $_POST['question'];
$selection = $_POST['selection'];
$question = $_POST['question'];
$block_id = $_POST['block_id'];

$s_no = ($s_type == 2) ? 0 : $_POST['s_no'];
$is_multiple = ($s_type > 0) ? 0 : 1;
//$s_type = $s_type - $is_multiple;
$s_type = ($s_type == 2) ? 2 : 1;

$bankno = $_SESSION['bank_no'];

if($_POST['option'] == "create"){
	db_query("insert into `survey_bank_question` (survey_bankno, block_id, question) values ('$bankno', $block_id, '$question');");
	header("location: ./question_list.php?block_id=$block_id&appear=view");
}else if($_POST['option'] == "update_question"){ 
	db_query("update `survey_bank_question` set question='$question' where survey_bankno=$bankno and survey_cd=$survey_cd;");
	header("location: ./question_list.php?block_id=$block_id&appear=view");
}else{
	db_query("update `survey_bank_question` set survey_type=$s_type, question='$question' where survey_bankno=$bankno and survey_cd=$survey_cd;");
	update_nonCoreData($s_type, $bankno, $survey_cd, $s_no, $selection, $is_multiple);
	header("location: ./question_list.php?block_id=$survey_cd&appear=view&reload=1");
}

function update_nonCoreData($s_type, $bankno, $survey_cd, $s_no, $select, $is_mult){
	$empty = 0;
	//選擇題
	if($s_type == 1)  $empty = count($select) - $s_no;
	else  $empty = count($select);

	//把不需要的selection欄位清空
	for($i = count($select) - 1 ; $i >= $s_no ; $i--)
		$select[$i] = "";

	db_query("update `survey_bank_question` set selection_no=$s_no, selection1='$select[0]',  selection2='$select[1]',  selection3='$select[2]', selection4='$select[3]',  selection5='$select[4]', selection6='$select[5]', is_multiple=$is_mult where survey_bankno=$bankno and survey_cd=$survey_cd;");
}
?>
