<?php
	/* author: ghsot777
	 * date: 2007/11/23
	 */
	require_once("../../config.php");
    require_once("../../session.php");

	global $THEME_PATH;
	global $DB_CONN, $WEBROOT;
	$input = $_POST;
	$tpl_path = $WEBROOT . $THEME_PATH . $_SESSION['template'];

	$reg = 1 - $DB_CONN->getOne("select is_register from online_survey_setup where survey_no=$input[survey_no];");
	db_query("update online_survey_setup set is_register=$reg where survey_no=$input[survey_no];");
	//1表示要記名
	if($reg == 1) echo $WEBROOT."$tpl_path/images/icon/name.gif";
	else echo $WEBROOT."$tpl_path/images/icon/name_x.gif";
	return 1;
?>
