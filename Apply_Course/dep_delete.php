<?php

	require_once("../config.php");
	global $DB_CONN;
	$del = $_GET['del'];

	if(isset($del)){
		$sql = "SELECT * FROM lrtunit_basic_ WHERE department=$del"; //��M���L�U�h�ؿ�
		$tmp = $DB_CONN->query($sql);
		if($tmp->numRows() == 0){  //�L�U�h�~�i�R��
			$sql = "DELETE FROM lrtunit_basic_ WHERE unit_cd = $del";
			$DB_CONN->query($sql);
			echo "Delete Success. <a href=dep_list.php>Return to list</a>";
		}
		else
			echo "Can't delete this course.";
	}
	else
		echo "Command Error";
		

?>
