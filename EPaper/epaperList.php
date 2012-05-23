<?
/*
DATE:   2007/03/31
AUTHOR: 14_不太想玩
*/
	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
	$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
	$absoluteURL = $HOMEURL . "EPaper/";


	session_start();
	$personal_id = $_SESSION['personal_id'];			//取得個人編號
	$role_cd = $_SESSION['role_cd'];					//取得角色
	
	$begin_course_cd = $_GET['begin_course_cd'];		//取得課程代碼
	if(isset($begin_course_cd) == false)	$begin_course_cd = $_SESSION['begin_course_cd'];	

	$behavior = $_GET['behavior'];						//取得行為

	if($role_cd == 0)//系統管理者
	{
		$begin_course_cd = -1;
	}


	//設定檔案路徑
	$FILE_PATH = $COURSE_FILE_PATH . $begin_course_cd . "/EPaper/";
	


	$tpl = new Smarty;
	$tpl->assign("imagePath", $IMAGE_PATH);
	$tpl->assign("cssPath", $CSS_PATH);
	$tpl->assign("absoluteURL", $absoluteURL);

	$tpl->assign("behavior", $behavior);
	
	if($behavior == "admin")//系統管理者
	{
		$tpl->assign("isDeleteOn", 1);		//是否允許刪除電子報
		$tpl->assign("isShowPublish", 1);	//是否顯示 電子報發布狀態
		$tpl->assign("isPublishOn", 1);		//是否允許重新發布電子報
		$isShowAll = 1;						//是否顯示所有電子報
	}
	else if($behavior == "teacher")//教師
	{
		$tpl->assign("isDeleteOn", 1);		//是否允許刪除電子報
		$tpl->assign("isShowPublish", 1);	//是否顯示 電子報發布狀態
		$tpl->assign("isPublishOn", 1);		//是否允許重新發布電子報
		$isShowAll = 1;						//是否顯示所有電子報
	}
	else if($behavior == "student")//學生
	{
		$tpl->assign("isDeleteOn", 0);		//是否允許刪除電子報
		$tpl->assign("isShowPublish", 0);	//是否顯示 電子報發布狀態
		$tpl->assign("isPublishOn", 0);		//是否允許重新發布電子報
		$isShowAll = 0;						//是否顯示所有電子報
	}	
	
	//是否顯示RSS訂閱
	$showRss = 1;
	$tpl->assign("showRss", $showRss);
	$tpl->assign("rssPage", "epaper_course_rss.php?personal_id=$personal_id&begin_course_cd=$begin_course_cd");
	
	//從Table e_paper搜尋這堂課的所有電子報
	$sql = "SELECT * FROM e_paper 
					WHERE 
						begin_course_no = $begin_course_cd 
					ORDER BY periodical_cd DESC";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	$resultNum = $res->numRows();
	
	if($resultNum > 0)
	{
		$rowCounter = 0;
		
		while ($res->fetchInto($row, DB_FETCHMODE_ASSOC) )
		{	
			if($isShowAll == 0)
			{
				if($row[if_auto]=='N')	continue;
				else if(TIME_date(1) < substr($row[d_public_day], 0, 8) )	continue;
			}
			
			//設定檔案路徑
			$epaper_file_url = $FILE_PATH . $row[epaper_file_url];
			$tmp_epaper_file_url = $epaper_file_url;	
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$tmp_epaper_file_url = substr($tmp_epaper_file_url, 0, strrpos($tmp_epaper_file_url, "/"));
			$epaper_file_url = $RELEATED_PATH . substr($epaper_file_url, strrpos($tmp_epaper_file_url, "/")+1, strlen($epaper_file_url));	
		
			$epaperList[$rowCounter] = 
					array(
							"epaper_cd" => $row[epaper_cd], 
							"periodical_cd" => $row[periodical_cd], 
							"begin_course_no" => $row[begin_course_no],
							"d_public_day" => substr($row[d_public_day], 0, 10),
							"if_auto" => $row[if_auto],
							"topic" => $row[topic], 
							"d_create_day" => $row[d_create_day], 
							"epaper_file_url" => $epaper_file_url
							);
			
			$rowCounter++;
		}
		$epaperNum = $rowCounter;
		
		$tpl->assign("epaperNum", $epaperNum);
		$tpl->assign("epaperList", $epaperList);
	}
	
	//目前的頁面
	$tpl->assign("currentPage", "epaperList.php");
	
	assignTemplate($tpl, "/epaper/epaperList.tpl");
?>
