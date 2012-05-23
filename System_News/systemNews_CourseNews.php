<?php
session_start();

$role_cd = $_SESSION['role_cd'];
$behavior = $_GET['behavior'];
$displayType = $_GET['displayType'];

if(isset($behavior) == false) {
	if($role_cd == 1 || $role_cd == 2){//老師
		$behavior = "teacher";
	}
	else if($role_cd == 3) {//學生
		$behavior = "student";
	}
	else {//其它
		$behavior = "";
	}
}

$redirectPage = "systemNews_courseShowList.php?behavior=$behavior&displayType=$displayType&finishPage=systemNews_CourseNews.php";	

//導向到systemNews_ShowList
header("location: " . $redirectPage);
?>

