<?php
	/*author: lunsrot
	 * date: 2007/07/08
	 */
	require_once("../config.php");
	require_once("../session.php");

	$input = $_GET;

	if(empty($input['style'])){
		//暫時先固定只有一個，以後再處理
		global $HOME_PATH, $IMAGE_PATH;
		$tpl = new Smarty;
		$path = $HOME_PATH . $IMAGE_PATH . "themes";
		if(!$dh = @opendir($HOME_PATH . $IMAGE_PATH . "themes"))	exit;
		$path = $path . "/";
		while($obj = readdir($dh)){
			if(is_dir($obj) || is_dir($path . $obj))	continue;
			$code = explode(".", $obj);
			if(empty($code[0]))	continue;
			$tpl->append("themes", array("img"=>$obj, "code"=>$code[0]));
		}
		assignTemplate($tpl, "/personal_page/changeTemplate.tpl");
	}else{
		$_SESSION['template'] = $input['style'];
		db_query("update `personal_basic` set personal_style='$input[style]' where personal_id=$_SESSION[personal_id];");
		header("location:./index.php");
	}
?>
