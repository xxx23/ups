<?php
/*author: lunrot
 * date: 2007/03/13
 */
require_once("config.php");

//清除 online_number 先放這 以後要移到 config
$sql = "DELETE FROM online_number WHERE personal_id='".$_SESSION[personal_id]."' and host='".$_SESSION[personal_ip]."'";
$res = db_query($sql);
//------------------------------------------------------
session_start();


LEARNING_TRACKING_stop(1, 1, -1, $_SESSION['personal_id']);

session_destroy();


header("location:./index.php");
?>
