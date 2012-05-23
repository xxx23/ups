<?php
/***************************************************************/
/* id: media_stream_input.php v1.0 2007/5/29 by hushpuppy Exp. */
/* function: 上傳影音串流檔案的介面								   */
/***************************************************************/
require_once('../config.php');
require_once('../session.php');
require_once('../library/content.php');

checkMenu("/Teaching_Material/textbook_manage.php");

//$file_name 	= urldecode($_GET['file']);
$file_name 	= $_GET['file']; // urlencode 過來就是要的資料了
$Content_cd = get_content_cd( $_SESSION['begin_course_cd'] );
$seq = $_GET['lookid'];

$smtpl = new Smarty;

if( isset($seq) )// edit 
{ 
	$get_info = " SELECT * FROM on_line WHERE content_cd=$Content_cd AND seq=$seq " ;
    $result = db_query($get_info);
	
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$smtpl->assign("today", substr($row['d_course'], 0, 10) );
	$smtpl->assign("subject", $row['subject']);
	$smtpl->assign("content", $row['media_content']);
	$smtpl->assign("looking", true);
	$smtpl->assign("lookid", $seq );
} 
else // insert 
{
	$today = date("Y-m-d");
	$smtpl->assign("today",$today);
	if(file_name != '') {
		$smtpl->assign("file_name", $file_name);
	}
}

assignTemplate( $smtpl,"/teaching_material/media_stream_input.tpl");
?>
