<?php 
/* 系統公告 管理者顯示頁面
DATE:   2009/09/20
AUTHOR: 14_不太想玩
Modify: arnan @ 2009/09/29
*/	
require_once('../config.php');
require_once('../session.php');
checkAdminTeacherTa();

require_once($HOME_PATH.'library/filter.php');
require_once("library.php");
//add for pure html
require_once $HOME_PATH.'library/purifier/HTMLPurifier.auto.php';
$config = HTMLPurifier_Config::createDefault(); 
$config->set('HTML', 'TidyLevel', 'none');
$config->set('HTML', 'AllowedElements', 'div,table,font,u,strong,a,img,p,br,span,h1,h2,h3,h4,h5,h6,i');
$config->set('HTML', 'AllowedAttributes', array('a.href', 'img.src', 'img.alt', '*.style'));   
$purifier = new HTMLPurifier($config);
//$purifier = new HTMLPurifier();
//end

$tpl = new Smarty;


//顯示哪一種公告 , 預設為所有課程
$news_type = optional_param('news_type', 'course-all', PARAM_SAFEDIR);	
$showAll = optional_param('showAll', 0, PARAM_INT) ; 

$personal_id = $_SESSION['personal_id'];


//是否顯示所有公告
//預設限制十筆
$sql_NumRows = ' limit 0, 10';
if($showAll == 1){ //顯示所有
	$sql_NumRows = '';
}

//搜尋需要種類的公告
$sql_get_news_type_where = get_news_type_where_sql($news_type) ;  

$get_admin_news = 'SELECT A.*, B.course_type FROM news A, news_target B '
	.' WHERE B.role_cd=0 AND A.news_cd=B.news_cd '.$sql_get_news_type_where
	.' ORDER BY A.d_news_begin DESC, A.news_cd DESC '. $sql_NumRows;
//echo $get_admin_news ;

$all_news = db_getAll($get_admin_news);


if( !empty($all_news) ) {

	$row_index = 0 ;
	foreach( $all_news as &$row ) {
		
		//轉換公告時間，判斷是否為最新公告
		$date = convert_date($row['d_news_begin']) ;
		$new = (TIME_date(1) <= ($date + 2))?
			1:0;

		//從Table news_upload取出資料
		$get_upload_files = "SELECT * FROM news_upload WHERE news_cd="
		."{$row['news_cd']} ORDER BY file_cd ASC ";
		
		$upload_files = db_getAll($get_upload_files);
		

		unset($file_list);
		foreach($upload_files as &$each_file) {
			$file_list[] = array(
				"showFile" => ($each_file['if_url']==0?1:0),
				"showUrl" => ($each_file['if_url']==1?1:0),
				'file_name'=> $each_file['file_name'],
				'file_url'=> ($each_file['if_url']==1? 
					$each_file['file_url']:$WEBROOT.$each_file['file_url'])
			);

		}
		
		
		$newsList[$row_index ++] = array(
			"news_cd" => $row['news_cd'],
			'course_type' => $row['course_type'],
			"date" => $date,
			"level" => convert_important($row['level']),
			"subject" => $row['subject'],
			"personal_name" => get_publish_name($row['personal_id']),
			"viewNum" => $row['frequency'],
			"new" => $new,
			"showContent" => ($row['content']==''?0:1),
			"content" => $purifier->purify($row['content']),
			"file_list" => $file_list
		);
		
	}// end of foeach 
}// end of check empty 




//=====================================================================
$IMAGE_PATH = $RELEATED_PATH . $IMAGE_PATH;
$CSS_PATH = $RELEATED_PATH . $CSS_PATH;
$absoluteURL = $HOMEURL . "System_News/";

$tpl->assign("newsList", $newsList);
$tpl->assign("newsNum", $row_index);

//是否顯示RSS訂閱
$showRss = 1;
$tpl->assign("showRss", $showRss);
$tpl->assign("rssPage", "systemNews_home_rss.php");

//是否顯示所有公告
$tpl->assign("showAll", $showAll);


$tpl->assign('news_type', $news_type);
$tpl->assign('is_sys_course_news', (strpos($news_type, 'course')>-1?1:0) ) ;

$tpl->assign("imagePath", $IMAGE_PATH);
$tpl->assign("cssPath", $CSS_PATH);

$behavior = "admin";
$tpl->assign("behavior", $behavior);

$tpl->assign("isNewOn", 1);		//是否允許新增公告
$tpl->assign("isModifyOn", 1);	//是否允許修改公告
$tpl->assign("isDeleteOn", 1);	//是否允許刪除公告

//目前的頁面
$tpl->assign("currentPage", "systemNews_adminShowList.php");

//Action結束後的頁面
$tpl->assign("finishPage", "systemNews_adminShowList.php");
$tpl->assign("show_title" , "1"); //公告列表

assignTemplate($tpl, "/system_news/systemNews_showList.tpl");
?>
