<?php 
//列出開課帳號，使用者透過此介面管理
include("../config.php"); 
include("../library/filter.php"); 

$tpl = new Smarty ; 

echo "<br/>";
assignTemplate($tpl, "/apply_course/login.tpl");


?>
