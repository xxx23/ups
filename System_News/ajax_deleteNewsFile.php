<?php
//ajax 修改news 可以動態刪除檔案 

require_once('../config.php') ; 
require_once('../session.php') ; 

checkAdminTeacherTa();


$news_cd = $_POST['news_cd'] ; 
$file_cd = $_POST['file_cd'] ;

//從Table news_upload取出資料
$get_upload_files = "SELECT file_url FROM news_upload WHERE news_cd="
."$news_cd and file_cd=$file_cd ORDER BY file_cd ASC ";

$upload_files_path = db_getOne($get_upload_files);

FILE_del($HOME_PATH, $upload_files_path ); 

if( !file_exists($HOME_PATH .$upload_files_path) ) {
	//成功刪除檔案後才刪除資料庫的資料
	$del_upload_files = "delete FROM news_upload WHERE news_cd="
		."$news_cd and file_cd=$file_cd";
	db_query($del_upload_files) ;
	echo "檔案已刪除!";
}else {
	echo "檔案刪除失敗!";
}
?>