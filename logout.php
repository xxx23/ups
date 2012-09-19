<?php
/*author: lunrot
 * date: 2007/03/13
 */
require_once("config.php");
global $USE_MYSQL, $USE_MONGODB, $db;
//清除 online_number 先放這 以後要移到 config
session_start();
if($USE_MYSQL)
{
	$sql = "DELETE FROM online_number WHERE personal_id='".$_SESSION['personal_id']."' and host='".$_SESSION['personal_ip']."'";
	$res = db_query($sql);
}
else if($USE_MONGODB)
{
	$online_number = $db->online_number;
	$online_number->remove(array('pid' => $_SESSION['personal_id'], 'h' => $_SESSION['personal_ip']));
}
//------------------------------------------------------


LEARNING_TRACKING_stop(1, 1, -1, $_SESSION['personal_id']);

session_destroy();


header("location:./index.php");
?>
