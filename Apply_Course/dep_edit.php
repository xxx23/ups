<?php

	require_once("../config.php");
	require_once("../session.php");
	global $DB_CONN;
	$ed = $_GET['ed'];

	// modify by Samuel @ 09/08/17
	// ¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿
	// ¿¿¿query¿sql.


	$submit = $_POST['submitbutton'];
	$unit_cd = $_POST['unit_cd'];
	$unit_name = $_POST['unit_name'];
	//$unit_abbrev = $_POST['unit_abbrev'];
	//$unit_e_name = $_POST['unit_e_name'];
	//$unit_e_abbrev = $_POST['unit_e_abbrev'];
	//$department = $_POST['department'];

	$tpl = new Smarty();

	if(empty($submit)){ 
		$sql = "SELECT * FROM lrtunit_basic_ WHERE unit_cd = $ed";
		$result = $DB_CONN->query($sql);

		while($record=$result->fetchRow(DB_FETCHMODE_ASSOC)){ 
			$tpl->append("Department", $record);
		}

		$tpl->assign('finish',0);
	}
	else{
	  	$sql = "UPDATE lrtunit_basic_ SET unit_name = '{$unit_name}' WHERE unit_cd={$unit_cd}";
		/*
		$sql = "UPDATE lrtunit_basic_ SET unit_name='{$unit_name}'
			unit_abbrev='$unit_abbrev',
			unit_e_name='$unit_e_name',
		      	unit_e_abbrev='$unit_e_abbrev',
		  	department=$department 
			WHERE unit_cd = $unit_cd";
		*/
		$DB_CONN->query($sql);
		$tpl->assign('finish',1);

	}
	assignTemplate($tpl, "/course_admin/dep_edit.tpl");

?>
