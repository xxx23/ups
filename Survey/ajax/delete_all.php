<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../../config.php");
require_once("../../session.php");

$target = $_GET['survey_cd'];
$bankno = $_SESSION['bank_no'];

db_query("delete from `survey_bank_question` where survey_bankno=$bankno and block_id=$target;");
db_query("delete from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$target;");

echo "true";
?>
