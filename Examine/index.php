<?php
/*author: lunsrot
 * date: 2007/03/13
 */
$PATH = "../";
require_once($PATH . "config.php");
require_once($PATH . "session.php");

$role = $_SESSION['role_cd'];

if($role == "3"){
}else{
	header("location:./tea_view.php?option=exams");
}

?>
