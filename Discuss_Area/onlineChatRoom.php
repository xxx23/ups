<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "Discuss_Area/";

	session_start();
	$personal_id = $_SESSION['personal_id'];				//取得個人編號
	$role_cd = $_SESSION['role_cd'];						//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];		//取得課程代碼
	
	$link = "../Chat_Room/index.php?pid=$personal_id";
	//header("Location: ../Chat_Room/index.php?pid=$personal_id");

?>


<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	//window.name = 'rootWindow';
	window.remoteWindow.window.focus();
}

pop('<?echo $link?>','remoteWindow','width=550,height=400,scrollbars,resizable')

</script>
