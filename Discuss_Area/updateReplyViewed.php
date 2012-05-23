<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH."session.php");
	require_once($RELEATED_PATH."config.php");
	
	session_start();
	$personal_id = $_SESSION['personal_id'];
	$begin_course_cd = $_SESSION['begin_course_cd'];
	$discuss_cd = $_SESSION['discuss_cd'];
	$discuss_content_cd = $_SESSION['discuss_content_cd'];
	
	$behavior = $_GET['behavior'];
	if(isset($behavior))
	  	$behavior = $_POST['behavior'];

	$reply_content_cd = $_POST['reply_content_cd'];

	//判斷這一筆資料是否已經存在在資料庫了
	$sql = "SELECT * FROM discuss_content_viewed 
	  WHERE begin_course_cd = $begin_course_cd
	  AND discuss_cd = $discuss_cd
	  AND discuss_content_cd = $discuss_content_cd
	  AND reply_content_cd = $reply_content_cd
	  AND personal_id = $personal_id";

	$result = $DB_CONN->query($sql);
	$result_num = $result->numRows();
	
	if( $result_num == 0 )//表示資料不存在於資料庫中
	{
		//將看過的文章篇號寫進去資料中
		$sql = "INSERT INTO discuss_content_viewed
		  (begin_course_cd , 
		   discuss_cd,
		   discuss_content_cd,
		   reply_content_cd,
		   personal_id)
		   VALUES
		   (
		      $begin_course_cd,
		      $discuss_cd,
		      $discuss_content_cd,
		      $reply_content_cd,
		      $personal_id)";
	
		//file_put_contents("/tmp/a.txt",$sql);
		$res = $DB_CONN->query($sql);
	}
	
	//重新回到那一個頁面
	//header("Location:showArticle.php?behavior=$behavior&discuss_cd=$discuss_cd&discuss_content_cd=$discuss_content_cd");
?>
