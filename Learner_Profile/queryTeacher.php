<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");

	$tpl = new Smarty();

	if($_GET['p'])
	{
		$personal_id = $_GET['p'];
		$role_cd = db_getOne("select role_cd from register_basic where personal_id=$personal_id");

		if($role_cd == 1)
		{
		  	$row = db_getRow("select * from personal_basic where personal_id=$personal_id");
			if($row)
			{
			  	$tpl->assign("teacher_name",$row['personal_name']);
			  	$tpl->assign("skill",$row['skill']);
			  	$tpl->assign("jog",$row['job']);
			  	$tpl->assign("introduction",$row['introduction']);
			  	$tpl->assign("experience",$row['experience']);
				$tpl->assign("email",$row['email']);

				assignTemplate($tpl,"/learner_profile/queryTeacher.tpl");
			}
		}
	}





?>
