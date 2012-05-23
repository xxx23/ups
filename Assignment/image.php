<?php
	/*author: lunsrot
	 * date: 2007/07/08
	 */
	require_once("../config.php");
	require_once("../session.php");

	if ( $action == "uploadpage" ) {
		uploadpage ();
	}
	else if ( $action == "upload" ) {
		if( eregi( "\.php$", $upname ) || eregi("\.cgi$", $upname) )
			echo "不合法檔案<br>";
		else
		{ 
			if ( fileupload ( $upfile, "../../$course_id/homework/upload", $upname, $mode=0644 )) {
				$fp = fopen( "../../$course_id/homework/comment/$upname.txt", "w+" );
				if($fp)
				{
					fputs( $fp, $comment );
					fclose( $fp );
				}
			}
		}
		uploadpage ();
	}
	else
		show_page_d();

	function show_page_d () {
		$tpl = new Smarty;
		assignTemplate($tpl, "/assignment/image.tpl");
	}

function uploadpage () {
	global $version, $message;
	include("class.FastTemplate.php3");
	$tpl = new FastTemplate("./templates");
	if($version == "C")
		$tpl->define( array(main=>"upload_image.tpl") );
	else
		$tpl->define( array(main=>"upload_image.tpl") );
	$tpl->assign(MESSAGE,$message);
	$tpl->parse(BODY,"main");
	$tpl->FastPrint("BODY");
}

?>
