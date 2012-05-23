<?php 

include("../config.php") ; 
	
//$tpl = new Smarty; 
require_once($HOME_PATH . 'library/smarty_init.php');

$citys = db_getAll("SELECT DISTINCT city_cd,city FROM location WHERE 1;");
$tpl->assign('citys',$citys);

assignTemplate($tpl, "/apply_course/apply_begincourse_account.tpl");

?>
