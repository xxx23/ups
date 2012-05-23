<?php
/*author: lunsrot
 * date: 2007/03/13
 */
require_once("../config.php");
require_once("../session.php");

$role = $_SESSION['role_cd'];

if($role == "3"){
	header("location:./stu_assign_view.php");
}else{
	header("location:./tea_view.php");
}

?>
