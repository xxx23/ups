<?php
/*********************************************************/
/* id: media_stream.php v1.0 2007/8/8 by hushpuppy Exp. */
/* function: 影音串流檔案的主介面		         */
/*********************************************************/
include "../config.php";
require_once "../library/file.php";
require_once "../library/content.php";
require_once("../session.php");
require_once($HOME_PATH. 'library/smarty_init.php');

//error_reporting(E_ALL);
checkMenu("/Teaching_Material/media_stream.php");


	//$smtpl = new Smarty;
	
	$Content_cd = get_Content_cd($_SESSION['begin_course_cd']);
	if($Content_cd == 0) {
		$tpl->assign("no_content", 1);
		assignTemplate($tpl,"/teaching_material/media_stream.tpl");
		return ;
	}

$Personal_id 	= get_Teacher_id($Content_cd); 
$Date 			= $_POST['date'];
$Subject 		= $_POST['subject'];
$Content 		= $_POST['content'];
$File_option 	= $_POST['file_option'];	// 影像擋


// $Curr_path = $STREAMING_FILE_PATH;  no used

// do make sure the file path has directorys 

$Curr_path = get_Media_path($MEDIA_FILE_PATH, $Personal_id, $Content_cd) ; 
	
//上傳功能
if( isset($File_option) ){ // 上傳影像擋 or URL
	
	$subject_emtpy_flag = empty($Subject);// check no subject input
	
	if( $File_option== "upload" and !$subject_emtpy_flag) { // upload 
		$file_name = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		if( $file_type == "application/x-php" || $file_type == "application/x-js"){ // check no upload php or js 
			header("Location: ../alert.html");
			return;
		}
		$tmp = $_FILES['file']['tmp_name'];
		// copy temp file to target dir
		
		$file_exists_flag = file_exists($Curr_path.$file_name); // file name duplicate 
		$strang_name_flag = (preg_match('/[\\\'%"<>:?|`]/', $file_name) == 1) ; // prevent strang file name 
		if( !$file_exists_flag and !$strang_name_flag and !FILE_upload($tmp, $Curr_path, $file_name)  ) {
			header("Location: upload_fail.html");
		}
	}
	if($File_option == "filelink"){ // upload URL 
		$file_name = $_POST['rfile'];
	}
	//re-upload   , all validate ok , otherwise redirect to input 
	if(  $file_exists_flag or $strang_name_flag or $subject_emtpy_flag  ) 
	{
		$tpl->assign("subject", $Subject);
		$tpl->assign("content", $Content);
		$tpl->assign("today", $Date);
		if($file_exists_flag )
			$tpl->assign("file_name_duplicate", true);

		if($strang_name_flag == 1) 
			$tpl->assign("strang_name_flag",true);
			
		if($subject_emtpy_flag ) {
			$tpl->assign("subject_emtpy_flag", true);
		}	
		assignTemplate( $tpl,"/teaching_material/media_stream_input.tpl");
		return ;
	}
	
	$rfile = $file_name ;
}


if( isset($File_option) ) {  //新增一個教材
	$insert_new_record = "insert into on_line (content_cd, d_course, subject, media_content, rfile) "
	." values ('$Content_cd', '$Date', '$Subject', '$Content',  '$rfile');";
	db_query($insert_new_record);
	header('Location: '.$_SERVER['PHP_SELF']);
	return ;
}


//update 資料
if( isset($_POST['lookid']) ){
  	$lookid = intval($_POST['lookid']);
	$update_record = " UPDATE on_line SET d_course='$Date' , subject='$Subject', media_content='$Content' "
    . " WHERE content_cd=$Content_cd AND seq=$lookid ";
	db_query($update_record);
	header('Location: '.$_SERVER['PHP_SELF']);
	return ;	
}


//刪除ftp內的資料 ( 刪除沒有meta data的資料 )
if( isset($_GET['ftp_del_filename']) ) {
	$file_name = urldecode($_GET['ftp_del_filename']); 
	if( !FILE_del($Curr_path, $file_name)   ) {
		header("Location: upload_fail.html");
	}
	header('Location: '.$_SERVER['PHP_SELF']);
}



//刪除 (多筆)
if( isset($_POST['seq']) && !empty($_POST['seq'])) { // !! 還沒勾選刪除檔案
	foreach($_POST['seq'] as $seq ) 
	{
	  	$get_the_seq = " SELECT rfile FROM on_line WHERE content_cd='$Content_cd' AND seq='$seq'";
		$result = db_query($get_the_seq);
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		/* do not delete file , just delete the meta data
		if( strstr($row['rfile'], '/' ) == false ) { // check not URL 
		  	FILE_del($Curr_path, $row['rfile']);
		}
		*/
		$delete_the_seq = " DELETE FROM on_line WHERE content_cd='$Content_cd' AND seq='$seq'";
	    db_query($delete_the_seq);
	}
}

include ('../Weboffice/my_on_line_video_syn.php');


$sql = "select * from on_line where content_cd = '$Content_cd' ";
$result = db_query($sql);

$FileInDB = array();

while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
	$row['d_course'] = trim($row['d_course'],"00:00:00");
	//$row['rfile_url'] = base64_encode($row['rfile']);
	$FileInDB[] = $row['rfile'];
	$tpl->append("content",$row);
}

//Get Dir entry , filter out the files in DB
if( is_dir($Curr_path) ) {

	$dir_fd = dir($Curr_path);
	
	while( ($file_name = $dir_fd->read()) != false) {
		// filter out the current dir , and parent dir , and directorys 
		if (strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0 || is_dir($curr_path.$file_name)== true ){
			continue;
		}
		$row['file_name'] = $file_name;
		$row['file_name_64encode'] = urlencode($file_name);
		if( !in_array($file_name, $FileInDB) ){
			$tpl->append("list_dir",$row) ;
		}
	}
}
//$tpl->assign("content_cd", $Content_cd);

$get_login_id = "select login_id from register_basic where personal_id={$_SESSION['personal_id']}";
$login_id = db_getOne($get_login_id);
//get From config.php
$ftp_path = "ftp://".$login_id."@".$FTP_IP.":".$FTP_PORT."/video/";

$tpl->assign("ftp_ip",$FTP_IP);
$tpl->assign("ftp_port",$FTP_PORT);
$tpl->assign("ftp_path",$ftp_path);
assignTemplate( $tpl,"/teaching_material/media_stream.tpl");

function get_Media_path($media_files_path , $personal_id, $content_cd) {
	$media_path = $media_files_path . $personal_id ;
	if( !is_dir($media_path) ) {  // 如果沒有這個資料夾 則新增
		createPath( $media_path );
	}
	
	$media_path .="/".$content_cd."/";
	if( !is_dir($media_path) ){
		createPath($media_path);
		//well_print($media_path);
	}
	return $media_path;
}
?>
