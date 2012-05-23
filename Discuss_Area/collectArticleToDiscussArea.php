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
	$discuss_cd = $_SESSION['discuss_cd'];					//取得討論區編號
	
	$discuss_content_cd = $_GET['discuss_content_cd'];		//取得文章編號
	if( isset($discuss_content_cd) == false)	$discuss_content_cd = $_POST['discuss_content_cd'];

	$behavior = $_GET['behavior'];						//取得行為
	if( isset($behavior) == false)	$behavior = $_POST['behavior'];

	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("javascriptPath", $JAVASCRIPT_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("src_discuss_cd", $discuss_cd);
	$tpl->assign("src_discuss_content_cd", $discuss_content_cd);
	
	$tpl->assign("behavior", $behavior);
	
	//從Table discuss_info搜尋課程的所有精華區
	$sql = "SELECT * FROM discuss_info WHERE begin_course_cd=$begin_course_cd AND discuss_name LIKE '精華區_%' ORDER BY discuss_cd ASC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$discussAreaNum = $res->numRows();

	if($discussAreaNum > 0)
	{
		$rowCounter = 0;
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			$discuss_name = str_replace("精華區_", "", $row[discuss_name]);
		
			$discussAreaList[$rowCounter] = 
					array(
							"discuss_cd" => $row[discuss_cd], 
							"discuss_name" => $discuss_name, 
							"discuss_title" => $row[discuss_title]
							);
			
			$rowCounter++;
		}
		$tpl->assign("discussAreaNum", $rowCounter);
		$tpl->assign("discussAreaList", $discussAreaList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "collectArticleToDiscussArea.php");
	
	if(isset($isShowSmartyTemplate) == 0)	$isShowSmartyTemplate = 1;
	
	if($isShowSmartyTemplate == 1)	assignTemplate($tpl, "/discuss_area/collectArticleToDiscussArea.tpl");
?>
