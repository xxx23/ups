<?php
/*********************************************************/
/* id: media_stream.php v1.0 2007/8/8 by hushpuppy Exp. */
/* function: 影音串流檔案的主介面		         */
/*********************************************************/

//error_reporting(E_ALL);
require_once( "../config.php");
require_once("../session.php");
checkMenu("/Teaching_Material/stu_media_stream.php");
include "../library/content.php";


	$content_cd 		= get_Content_cd($_SESSION['begin_course_cd']);
	$personal_id 		= get_Teacher_id($content_cd);

	$media_path = basename($MEDIA_FILE_PATH);
	
	$the_media_path = "../$media_path/" . $personal_id . "/$content_cd/";

	$smtpl = new Smarty;

	$get_this_content_medias = "select * from on_line where content_cd=$content_cd";
	$result = db_query($get_this_content_medias);

	while( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ) 
	{
		$row['d_course'] = trim($row['d_course'],"00:00:00");
		$row['rfile_url'] = urlencode($row['rfile'] );

		if( strstr($row['rfile'],"://") == false ) {
			$row['is_outer_url'] = 1;
		}
		$smtpl->append("content",$row);
	}
	$smtpl->assign("the_media_path", $the_media_path );

	assignTemplate( $smtpl,"/teaching_material/stu_media_stream.tpl");
?>