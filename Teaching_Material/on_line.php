<?php 
require_once "../config.php";
require_once "../session.php";
checkMenu("/Teaching_Material/media_stream.php");
include	"../library/content.php";

$seq = intval($_GET['seq']) ; 
$Content_cd = get_content_cd($_SESSION['begin_course_cd']);
$Personal_id = get_Teacher_id($Content_cd); // get_teacher_id ; 

$get_file_url = " SELECT * FROM on_line WHERE content_cd=$Content_cd and seq=$seq";
$result = db_query($get_file_url);
$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
$file = $row['rfile'];
$dtime   = $row['d_course'] ; 
$subject = $row['subject'];
$content = $row['media_content'];


if($Content_cd==0 or $Personal_id==0 or $seq==0){
	die("Page error");
}
if( !isset($seq) )
	$file = urldecode($_GET['file']) ;


$Media_path = '../'. basename($MEDIA_FILE_PATH) .'/'. $Personal_id .'/' . $Content_cd . '/';
if( !is_dir($Media_path) ) {
	die("Page error");
}

$Media_URL = $Media_path.$file;
if(  strstr($file,"://")== false and !file_exists($Media_URL) ) { 
	//well_print( $Media_URL );
	die("file is not exist");
}	


//well_print($Media_URL);
//well_print("<a href='$Media_URL'>taasfasdf</a>");
//die("afjdslalsd$file");
//get file type ÇØ
$file_type = strtolower( substr(strrchr($file,"."),1 , strlen(strrchr($file,"."))-1 )) ;


//check file type 
$vedio_filetype = array('wma','wmv', 'asf', 'mpeg', 'mpg', 'mp3') ;
//$audio_filetype = array('mp3');
$image_filetype = array('jpeg', 'jpg', 'bmp' , 'gif');
//echo $Media_URL;

if( strstr($file,"://") == false ) // imply outer URL link 
{ //not find URL Link 
	
	$smtpl = new Smarty;
	
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
	
	assignTemplate( $smtpl,"/teaching_material/on_line.tpl");

	return ;
}else{
	//die($file);
	header("Location: $file");	
	return;
}
?>