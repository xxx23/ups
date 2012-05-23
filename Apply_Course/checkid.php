<?
require("config.php");
$userid = $_POST['Courseid_id'];
$flag = false;

if(empty($userid)){
	header("Location: sendid.php?n=0");
	}
else{
	$data = mysql_query("select count(*) from register_course_id where courseid_id = '$userid'");
	list($count) = mysql_fetch_row($data);
	mysql_free_result($data);
	}
	
if($count != 0) 
	$flag = true;

if($flag == true){
	header("Location: sendid.php?n=1");
	}
else{
	header("Location: sendid.php?n=2");
	}
?>
