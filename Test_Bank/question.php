<?php
	/*author: lunsrot
	 * date: 2008/04/26
	 */
	require_once("../config.php");
	require_once("../session.php");

	$tpl = new Smarty;
	$type = $_GET['type'] . ".tpl";
	assignTemplate($tpl, "/test_bank/" . $type);
?>
