<?php
/***************************************************************/
/* id: media_stream_input.php v1.0 2007/5/29 by hushpuppy Exp. */
/* function: 上傳影音串流檔案的介面	 */
/*  Same function as on_line.php */ 
/***************************************************************/



require_once("../config.php");
require_once("../session.php");
checkMenu("/Teaching_Material/stu_media_stream.php");
include	"../library/content.php";


	$Content_cd = get_content_cd($_SESSION['begin_course_cd']);
	$Personal_id = get_Teacher_id($Content_cd); // get_teacher_id ; 
	
	$seq = intval($_GET['seq']) ; 

	$is_url = false ;
	if(isset($_GET['op']) and $_GET['op']=='detail' ){
		$is_url = true;
	}

	if($Content_cd==0 or $Personal_id==0 or $seq==0){
		die("Page error");
	}


$get_file_url = " SELECT * FROM on_line WHERE content_cd=$Content_cd and seq=$seq";
$result = db_query($get_file_url);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$file = $row['rfile'];
$dtime   = $row['d_course'] ; 
$subject = $row['subject'];
$content = $row['media_content'];

//show media 
if( !$is_url and strstr($file,"://") == false) {

	$Media_path = '../'. basename($MEDIA_FILE_PATH) .'/'. $Personal_id .'/' . $Content_cd . '/';
	if( !is_dir($Media_path) ) {
		//echo $Media_path;
		die("Page error");
	}
	$Media_URL = $Media_path.$file;
	if(  strstr($file,"://")== false and  !file_exists($Media_URL) ) { 
	//well_print( $Media_URL );
	die("file is not exist");
	}		
	
	$smtpl = new Smarty;

	$file_type = File_subtype($file) ;
	//check file type 
	$vedio_filetype = array('wma','wmv', 'asf', 'mpeg', 'mpg', 'mp3') ;
	//$audio_filetype = array('mp3');
	$image_filetype = array('jpeg', 'jpg', 'bmp' , 'gif');
	//echo $Media_URL;
	
	
	//find type to do something 
	if( in_array($file_type , $vedio_filetype) ) {
		$smtpl->assign("is_vedio", true );
	//}if( in_array($file_type , $audio_filetype) ) {
	//	$smtpl->assign("is_audio", true );
	}else if( in_array($file_type, $image_filetype)){
		$smtpl->assign("is_image", true );
	}else{
		$smtpl->assign("unknown", true ) ;
	}
	$smtpl->assign("subject", $subject);
	$smtpl->assign("content", $content);
	$smtpl->assign("dtime", trim($dtime,"00:00:00"));
	$smtpl->assign("media_url", $Media_URL);
	
	assignTemplate( $smtpl,"/teaching_material/stu_media_stream_detail.tpl");

	return ;
}else if( $is_url ){ // 看外部網址的詳細資訊
	
	$smtpl = new Smarty;
	
	$smtpl->assign("subject", $subject);
	$smtpl->assign("content", $content);
	$smtpl->assign("dtime", trim($dtime,"00:00:00"));
	$smtpl->assign("outer_url", $file);
	$smtpl->assign("is_outer_url", true);
	assignTemplate( $smtpl,"/teaching_material/stu_media_stream_detail.tpl");
	return ;
	
	
}else {
	//die($file);
	header("Location: $file");	
	return;
}
?>
