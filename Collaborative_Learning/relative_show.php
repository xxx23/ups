<?php
	/*author: lunsrot
	 * date: 2007/07/26
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("lib/co_learn_lib.php");

//	checkMenu("/Collaborative_Learning/teacher/tea_main_page.php");
	global $DB_CONN, $COURSE_FILE_PATH;
	$course_cd = $_SESSION['begin_course_cd'];

	$tpl = new Smarty;
	$input = $_GET;

	$result = db_query("select * from `info_groups` where begin_course_cd=$course_cd and homework_no=$input[homework_no];");
	$groups = array();
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$tmp = array();
		$tmp['group_no'] = $row['group_no'];
		$tmp['group_name'] = $row['group_name'];
		$path = "$COURSE_FILE_PATH$course_cd/homework/$input[homework_no]/student/$row[group_no]/";
		$tmp['resources'] = getResource($path);
		array_push($groups, $tmp);
	}
	$tpl->assign("groups", $groups);

	assignTemplate( $tpl, "/collaborative_learning/relative_show.tpl");

	function getResource($path){
		$output = array();
		if(!is_dir($path))
			return $output;

		$d = dir($path);
		while(($entry = $d->read()) != false){
			if(is_dir($entry) == 1 || substr($entry, 0, 8) != "resource")
				continue;
			$tmp = array();
			$date = getdate(fileatime($path . $entry));
			$tmp['upload_time'] = "$date[year]-$date[mon]-$date[mday] $date[hours]:$date[minutes]:$date[seconds]";
			$tmp['file_path'] = $path . $entry;
			$_SESSION['current_path'] = $path;
			$encode_name = urlencode($entry);
			$tmp['file_name'] = $entry;
			$tmp['encode_name'] = $encode_name;
			array_push($output, $tmp);
		}
		return $output;
	}
?>
