<?php
	/*author: lunsrot
	 */
	include "../config.php";
	include "session.php";
	include "exam_info.php";

	$template = $_SESSION['template'];
	$view = $_GET['view'];

	if($view == "true"){
		$option=$_GET['option'];
		display_update($option);
	}else{
	  	update();
	}

	function display_update($option){
		if($option == "modify")
			$no = $_GET['test_no'];
		$tpl = new Smarty;
		assignTemplate($tpl, "/examine/update_exam.tpl");
	}

	function update(){
		$name = $_POST['name'];
		$type = $_POST['type'];
		$score = $_POST['score'];

		if( $type == 1 ) 
			$score = 0;
		else if( empty($score) )
			$score = $_SESSION['score'];
		session_unregister(score);
		$begin_course_id = $_SESSION['begin_course_cd'];
		$sql = "insert into test_course_setup (begin_course_cd, test_type, test_name, percentage) values($begin_course_id, $type, '$name', $score);";
		if( !$DB_CONN->query($sql) )
			echo "error";

		$result = $DB_CONN->query( "select test_no from test_course_setup where begin_course_cd=$begin_course_id and test_name='$name';");
		$row = $result->fetchRow();
		$_SESSION['test_no'] = $row[0];
		header("location:./tea_examine_main.php");
	}
?>
