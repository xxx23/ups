<?
	$RELEATED_PATH = "../";

	
	require_once($RELEATED_PATH . "config.php");	
/*modify by lunsrot at 2007/03/22*/
	require_once($RELEATED_PATH . "session.php");
/*modify end*/
	checkAdmin();
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$absoluteURL = $HOMEURL . "Jurisdiction/";


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	//目前的Action
	$tpl->assign("action", "new");	//new
	
	//目前的頁面
	$tpl->assign("currentPage", "newRole.php");
	
	assignTemplate($tpl, "/jurisdiction/roleInput.tpl");
?>
