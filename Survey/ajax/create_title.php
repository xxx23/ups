<?php
/*author: lunsrot
 * date: 2007/04/11
 */
require_once("../../config.php");
require_once("../../session.php");

$name = $_GET['title_name'];
$pid = getTeacherId();

$bankno = db_getOne("select survey_bankno from `survey_bank` where personal_id=$pid;");
$result = db_query("select survey_cd from `survey_bank_question` where survey_bankno=$bankno and question='$name'");
//先確定名稱是否重複
if($result->numRows() != 0){
  echo -1;
}else{
//新增
  db_query("insert into `survey_bank_question` (survey_bankno, block_id, survey_type, question) values ('$bankno', 0, 0, '$name');");
  $result = db_query("select survey_cd from `survey_bank_question` where survey_bankno=" . $bankno . " and question='$name';");
  $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
  echo $name . ";" . $row['survey_cd'];
}
?>
