<?
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	require_once($RELEATED_PATH . "session.php");
	$absoluteURL = $HOMEURL . "Discuss_Area/";
	
	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	$begin_course_cd = $_SESSION['begin_course_cd'];	//取得課程代碼
	$discuss_cd = $_SESSION['discuss_cd'];				//取得討論區編號
	
	$discuss_content_cd = $_GET['discuss_content_cd'];	//取得文章編號
	if( isset($discuss_content_cd) == false)	$discuss_content_cd = $_POST['discuss_content_cd'];
	
	$behavior = $_GET['behavior'];						//取得行為
	if( isset($behavior) == false)	$behavior = $_POST['behavior'];
	$type = $_GET['type'];						//是否是社群

	if( $role_cd == 1) //如果是老師
	{
	// 判斷是不是該課程的老師 
	}
	else if($role_cd == 3){ // role_cd = 3 指的是學生
	//判斷學生有沒有修該課程 並且文章是不是那名學生po的
	}
	
	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/Discuss_Area/";
	
	//從Table discuss_hoarding刪除被收藏的文章
	$sql = "DELETE FROM discuss_hoarding WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";	
	$sth = $DB_CONN->prepare($sql);	
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());
	
	//刪除這個主題所有文章的檔案
	$sql = "SELECT * FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	
	$resultNum = $res->numRows();
	if($resultNum > 0)
	{
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{
			
			$fileName = $row[file_picture_name];

			//刪除檔案
			@unlink($FILE_PATH . $fileName);
		}
	}
	
	//從Table discuss_content刪除回覆的文章
	$sql = "DELETE FROM discuss_content WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";	
	$sth = $DB_CONN->prepare($sql);		
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

	//從Table discuss_subject刪除文章
	$sql = "DELETE FROM discuss_subject WHERE begin_course_cd=$begin_course_cd AND discuss_cd=$discuss_cd AND discuss_content_cd=$discuss_content_cd";
	$sth = $DB_CONN->prepare($sql);		
	$res = $DB_CONN->execute($sth);
	if (PEAR::isError($res))	die($res->getMessage());

    if($type=='group')
	    header("Location: groupShowArticleList.php?behavior=$behavior");
    else
    	header("Location: showArticleList.php?behavior=$behavior");
?>
