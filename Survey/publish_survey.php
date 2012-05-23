<?php
/*author: lunsrot
 * date: 2007/04/13
 */
require_once("../config.php");
require_once("../session.php");
require_once("sur_info.php");

global $HOME_PATH;
$option = $_GET['option'];
$survey_no = $_GET['survey_no'];

if($option == "view"){
	$tpl = new Smarty;

	$tmp = gettimeofday();
	$time = getdate($tmp['sec']);
	$tpl->assign("beg_date", "$time[year]-$time[mon]-$time[mday]");
	$tpl->assign("end_date", "$time[year]-$time[mon]-$time[mday]");
	$tpl->assign("survey_no", $survey_no);

	assignTemplate($tpl, "/survey/publish_view.tpl");
}else{
	$input = $_GET;
	$begin = $input['beg_date'] . " 00:00:00";
	$end = $input['end_date'] . " 23:59:59";
	db_query("update `online_survey_setup` set d_survey_beg='$begin', d_survey_end='$end' where survey_no=$survey_no");

	header("location: ./tea_view.php");
}
?>
