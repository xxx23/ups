<?php
/* author: lunsrot
 * data: 2007/03/20
 */
require_once("../config.php");
require_once("../session.php");
require_once("course_info.php");

global $PERSONAL_PATH;
$pid = $_SESSION['personal_id'];
$role = $_SESSION['role_cd'];
$view = $_GET['view'];

if($view == "true"){
	//$tpl = new Smarty;
	require_once($HOME_PATH . 'library/smarty_init.php');
    $attribute = $DB_CONN->getOne("select attribute from `begin_course` where begin_course_cd={$_SESSION['begin_course_cd']};");
    $tmp = role_visibility($role, null, 0, 3, $_SESSION['begin_course_cd'],$attribute);
	$set = personal_visibility($tmp ,$pid,$_SESSION['begin_course_cd']);
	//為了保證無論如何使用者都可以看到功能設定此一選項
	if( $_SESSION['lang'] == "zh_tw" || !isset($_SESSION['lang']) )
		setSystemTool("系統工具", "功能設定");
	else
		setSystemTool("System tool", "Setting");
	$tpl->assign("level_0", $set);

	assignTemplate($tpl, "/course/function.tpl");
}else{
	//$tpl = new Smarty;
    require_once($HOME_PATH . 'library/smarty_init.php');
    $path = getPersonalPath($pid);
	if(!file_exists($path . "/{$_SESSION['begin_course_cd']}.xml")){
        createPath($path);

		$f = fopen($path . "/{$_SESSION['begin_course_cd']}.xml", "w");
		fclose($f);
		chmod($path . "/{$_SESSION['begin_course_cd']}.xml", 0664);
	}
	$f = fopen($path . "/{$_SESSION['begin_course_cd']}.xml", "w");
	fwrite($f, "<function>\n");
 
	/*因有三層選單，對應三層迴圈*/
	$level_0 = $_GET['menu_0'];
	for($i = 0 ; $i < count($level_0) ; $i++){
		fwrite($f, "<menu level=\"0\" type=\"course\" id=\"$level_0[$i]\">\n");
		$level_1 = $_GET[ 'menu_' . $level_0[$i] ];
		for($j = 0 ; $j < count($level_1) ; $j++){
			fwrite($f, "\t<menu level=\"1\" type=\"course\" id=\"$level_1[$j]\">\n");
			$level_2 = $_GET[ 'menu_' . $level_1[$j] ];
			for($k = 0 ; $k < count($level_2) ; $k++)
				fwrite($f, "\t\t<menu level=\"2\" type=\"course\" id=\"$level_2[$k]\"/>\n");
			fwrite($f, "\t</menu>\n");
		}
		fwrite($f, "</menu>\n");
	}
	fwrite($f, "</function>");

	fclose($f);
	$tpl->assign("done", 1);
	assignTemplate($tpl, "/course/function.tpl");
}
?>
