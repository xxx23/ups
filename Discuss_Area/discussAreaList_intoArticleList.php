<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	session_start();

	$begin_course_cd = $_GET['begin_course_cd'];
	$discuss_cd = $_GET['discuss_cd'];

	$behavior = $_GET['behavior'];						//取得行為
	
	$ArticleList = $_GET['ArticleList'];				//取得ArticleList的程式行為
	if( isset($ArticleList) == false)	$ArticleList = $_SESSION['ArticleList'];
	if( isset($ArticleList) == false)	$ArticleList = "";
	$_SESSION['ArticleList'] = $ArticleList;
	
	
	//註冊課程代碼到SESSION	
	if( isset($begin_course_cd) == true)	$_SESSION['begin_course_cd'] = $begin_course_cd;
	else									$begin_course_cd = $_SESSION['begin_course_cd'];

	//註冊討論區編號到SESSION
	$_SESSION['discuss_cd'] = $discuss_cd;	

	
	header("Location: showArticleList.php?behavior=$behavior");
?>
