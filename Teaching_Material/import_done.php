<?php
	/*author: lunsrot
	 * date: 2008/03/13
	 */
	require_once("../config.php");
	require_once("../session.php");

	checkMenu("/Teaching_Material/import_moodle.php");

	$input = $_GET;
	if(empty($input['option']))
		$input['option'] = "nothing";
	call_user_func($input['option'], $input);

	function moodle($input){
		$tpl = new Smarty;
		assignTemplate($tpl, "/teaching_material/import_done.tpl");
	}
?>
