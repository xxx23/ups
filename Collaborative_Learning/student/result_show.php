<?php
/*****************************************************************/
/* id: result_show.php v1.0 2007/6/20 by hushpuppy Exp.          */
/* function: 合作學習學生成果發表介面							     */
/*****************************************************************/
/* author: lunsrot
 * date: 2007/07/18
 */
require_once("../../config.php");
require_once("../../session.php");

$Begin_course_cd = $_SESSION['begin_course_cd'];

$template = $HOME_PATH."themes/".$_SESSION['template'];
$tpl_path = "/themes/".$_SESSION['template'];

$smtpl = new Smarty;

$sql = "select * from project_data where begin_course_cd = '$Begin_course_cd';";
$result = $DB_CONN->query($sql);
if(PEAR::isError($result))	die($result->userinfo);

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	$Homework_no = $row['homework_no'];
	$sql = "select * from homework where begin_course_cd = '$Begin_course_cd' and homework_no = '$Homework_no';";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
	
	$row['homework_name'] = $data['homework_name'];
	$row['d_dueday'] = $data['d_dueday'];
	$row['percentage'] = $data['percentage'];
	
	$sql = "select * from groups_member where student_id = '$Personal_id';";
	$num = $DB_CONN->query($sql);
	$row['num'] = $num->numRows();
	
	$smtpl->append("project_list", $row);
}
$smtpl->assign("tpl_path",$tpl_path);
assignTemplate( $smtpl, "/collaborative_learning/student/result_show.tpl");

?>

