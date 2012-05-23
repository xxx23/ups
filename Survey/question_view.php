<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../config.php");
require_once("../session.php");

$survey_cd = $_GET['survey_cd'];
$block_id = $_GET['block_id'];
$bankno = $_SESSION['bank_no'];

$result = $DB_CONN->getRow("select * from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$survey_cd;", DB_FETCHMODE_ASSOC);
$tpl = new Smarty;

$tpl->assign("question", $result['question']);
$tpl->assign("block_id", $block_id);

assignTemplate($tpl, "/survey/question_view.tpl");
?>
