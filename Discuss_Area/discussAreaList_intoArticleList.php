<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");

	session_start();

	$begin_course_cd = $_GET['begin_course_cd'];
	$discuss_cd = $_GET['discuss_cd'];

	$behavior = $_GET['behavior'];						//���o�欰
	
	$ArticleList = $_GET['ArticleList'];				//���oArticleList���{���欰
	if( isset($ArticleList) == false)	$ArticleList = $_SESSION['ArticleList'];
	if( isset($ArticleList) == false)	$ArticleList = "";
	$_SESSION['ArticleList'] = $ArticleList;
	
	
	//���U�ҵ{�N�X��SESSION	
	if( isset($begin_course_cd) == true)	$_SESSION['begin_course_cd'] = $begin_course_cd;
	else									$begin_course_cd = $_SESSION['begin_course_cd'];

	//���U�Q�װϽs����SESSION
	$_SESSION['discuss_cd'] = $discuss_cd;	

	
	header("Location: showArticleList.php?behavior=$behavior");
?>
