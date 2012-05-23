<?php
	/*author: lunsrot
	 * date: 2007/08/29
	 */
	require_once("../config.php");
	require_once("../session.php");

	$input = $_GET;
	call_user_func($input['option'], $input);

	//template
	function view($input){
		global $HOME_PATH, $IMAGE_PATH;
		$tpl = new Smarty;
		if(!$dh = @opendir($HOME_PATH . $IMAGE_PATH . "themes/personal"))	exit;
		while($obj = readdir($dh)){
			if($obj == "." || $obj == "..")	continue;
			$code = explode(".", $obj);
			if(empty($code[0]))	continue;
			$tpl->append("themes", array("img"=>$obj, "code"=>$code[0]));
		}
		$tpl->assign("done", $input['done']);
		assignTemplate($tpl, "/course/changeTemplate.tpl");
	}

	//function
	function change($input){
		$_SESSION['template'] = $input['style'];
		db_query("update `personal_basic` set course_style='$input[style]' where personal_id=$_SESSION[personal_id];");
		header("location:./changeTemplate.php?option=view&done=1");
	}
?>
