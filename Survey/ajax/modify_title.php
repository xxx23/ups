<?php
/*author: lunsrot
 * date: 2007/04/12
 */
require_once("../../config.php");
require_once("../../session.php");

$id = $_GET['index'];
$name = $_GET['name'];
$bankno = $_SESSION['bank_no'];

$old = $DB_CONN->getOne("select question from `survey_bank_question` where survey_bankno=$bankno and survey_cd=$id");
$result = db_query("select survey_cd from `survey_bank_question` where survey_bankno=$bankno and question='$name';");
if($result->numRows() >= 1){
  echo "false;$old";
}else{
  db_query("update `survey_bank_question` set question='$name' where survey_cd=$id and survey_bankno=$bankno;");
  echo "true;$name";
}
?>
