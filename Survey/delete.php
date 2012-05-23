<?php
/*author: lunsrot
 * date: 2007/05/04
 */
require_once("../config.php");
require_once("../session.php");

checkMenu("/Survey/tea_view_bank.php");

$bankno = $_SESSION['bank_no'];
$survey_cd = $_GET['survey_cd'];

$result = db_query("select block_id from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$survey_cd;");
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
db_query("delete from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$survey_cd;");

header("location: ./question_list.php?block_id=" . $row['block_id']);
?>
