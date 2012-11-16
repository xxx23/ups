<?php 
/* 系統公告 管理者顯示頁面
DATE:   2009/09/20
AUTHOR: 14_不太想玩
Modify: arnan @ 2009/09/29
*/	
$MONGO_ONLY = false;
require_once('../config.php');
// require_once('../session.php');


require_once($HOME_PATH.'library/filter.php');
require_once("library.php");

$tpl = new Smarty;


//顯示哪一種公告
$news_type = optional_param('news_type', 'system', PARAM_SAFEDIR);	
$showAll = optional_param('showAll', 0, PARAM_INT) ; 

// $personal_id = $_SESSION['personal_id'];

$newsList = array();

$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 
//是否顯示所有公告
//預設限制十筆
for($i = 0; $i < 10000; $i++)
{

if($USE_MYSQL)
{
	$sql_NumRows = ' limit 0, 10';
	// if($showAll == 1){ //顯示所有
	// 	$sql_NumRows = '';
	// }

	//搜尋需要種類的公告
	$sql_get_news_type_where = get_news_type_where_sql($news_type) ;  

	$get_admin_news = 'SELECT A.news_cd, A.subject, A.personal_id, A.d_news_begin, A.content, A.important, A.frequency, B.course_type FROM news A, news_target B '
		.' WHERE B.role_cd=0 AND A.news_cd=B.news_cd '.$sql_get_news_type_where
		.' ORDER BY A.d_news_begin DESC'. $sql_NumRows;

	$all_news = db_getAll($get_admin_news);

	if( !empty($all_news) ) {

		$row_index = 0 ;
		$new = 0;
		foreach( $all_news as &$row ) {

			//轉換公告時間，判斷是否為最新公告
			/* $date = convert_date($row['d_news_begin']) ; */
			$date = $row['d_news_begin'];
			// $new = (TIME_date(1) <= ($date + 2))?
			// 	1:0;

			//從Table news_upload取出資料
			$cd = intval($row['news_cd']);
			$get_upload_files = "SELECT file_name, file_url, if_url FROM news_upload WHERE news_cd={$cd}";

			$upload_files = db_getAll($get_upload_files);


			unset($file_list);
			foreach($upload_files as &$each_file)
			{
				$file_list[] = array(
					"showFile" => ($each_file['if_url']==0?1:0),
					"showUrl" => ($each_file['if_url']==1?1:0),
					'file_name'=> $each_file['file_name'],
					'file_url'=> ($each_file['if_url']==1? 
					$each_file['file_url']:$WEBROOT.$each_file['file_url'])
				);

			}


			$newsList[$row_index ++] = array(
				"news_cd" => $cd,
				'course_type' => $row['course_type'],
				"date" => $date,
				"level" => convert_important($row['important']),
				"subject" => $row['subject'],
				"personal_name" => get_publish_name(intval($row['personal_id'])),
				"viewNum" => $row['frequency'],
				"new" => $new,
				"showContent" => ($row['content']==''?0:1),
				"content" => $row['content'],
				"file_list" => $file_list
			);

		}// end of foeach 
	}// end of check empty 
}
else if($USE_MONGODB)
{
	$news = $db->news;
	$query = array(
		'r' => 0,
		'ct' => 0
	);
	$projector = array(
		's' => 1,
		'p' => 1,
		'db' => 1,
		'c' => 1,
		'i' => 1,
		'f' => 1,
		'ct' => 1,
		'u' => 1,
		/* 'u.$.t' => 0, */
		/* 'u.$.f' => 0 */
	);
	$cursor = $news->find($query, $projector)->sort(array('cb' => -1))->limit(10);
	$new = 0;
	$row_index = 0;
	if($cursor->hasNext())
	{
		$all_news = iterator_to_array($cursor);
		foreach($all_news as &$row)
		{
			$date = $row['db'];
			// $new = (TIME_date(1) <= ($date + 2))?
			// 	1:0;

			$file_list = array();
			foreach($row['u'] as &$each_file)
			{
				$f = array(
					"showFile" => ($each_file['iu']==0?1:0),
					"showUrl" => ($each_file['iu']==1?1:0),
					/* 'file_name'=> $each_file['n'], */
					'file_url'=> ($each_file['iu']==1? 
					$each_file['u']:$WEBROOT.$each_file['u'])
				);
				if(array_key_exists('n', $each_file))
				{
					$f['file_name'] = $each_file['n'];
				}
				$file_list[] = $f;
			}
			$newsList[$row_index ++] = array(
				"news_cd" => $row['_id'],
				'course_type' => $row['ct'],
				"date" => $date,
				"level" => convert_important($row['i']),
				"subject" => $row['s'],
				"personal_name" => get_publish_name($row['p']),
				"viewNum" => $row['f'],
				"new" => $new,
				"showContent" => ($row['c']==''?0:1),
				"content" => $row['c'],
				"file_list" => $file_list
			);
		}
	}
}
}
$end=microtime();
$end=explode(" ",$end);
$end=$end[1]+$end[0];

printf("%f\n",$end-$start);
die();
//=====================================================================
$RELEATED_PATH = '../';
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

$tpl->assign("isNewOn", 0);		//是否允許新增公告
$tpl->assign("isModifyOn", 0);	//是否允許修改公告
$tpl->assign("isDeleteOn", 0);	//是否允許刪除公告

//目前的頁面
$tpl->assign("currentPage", "systemNews_homeShowList.php");

//Action結束後的頁面
$tpl->assign("finishPage", "systemNews_homeShowList.php");
$tpl->assign("show_title" , "1"); //公告列表

assignTemplate($tpl, "/system_news/systemNews_showList.tpl");
?>
