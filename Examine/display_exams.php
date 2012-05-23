<?php
	/* author: lunsrot
	 * date:2007/06/30 modify
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("exam_info.php");

	$option = $_GET['option'];
	$course_cd = $_SESSION['begin_course_cd'];
	$tmp = gettimeofday();
	$time = $tmp['sec'];

	if(empty($option)){
		$tpl = new Smarty;

		$tpl->assign('display_str', array("所有測驗", "已結束測驗", "未設定測驗", "已發佈測驗", "未發佈測驗", "進行中測驗"));
		$tpl->assign('display_order', array("測驗名稱", "配分", "發佈時間", "測驗時間"));
		$sql = "select * from `test_course_setup` where begin_course_cd=$course_cd order by percentage desc, test_name;";
		$result = $DB_CONN->query($sql);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$row['test_type_str'] = ($row[test_type] == 2) ? "正式測驗" : "自我評量";
			$row['string'] = "發佈時間：".$row[d_test_public]."<br/>"."測驗開始：".$row[d_test_beg]."<br/>"."測驗結束：".$row[d_test_end];
			if($row[d_test_public] == NULL)
				$row['state'] = "未設定";
			else if( timecmp( $time, strtotime($row[d_test_end]) ) == 1 ){
				$row['state'] = "測驗結束";
			}else if( timecmp( $time, strtotime($row[d_test_beg]) ) == 1 ){
				$row['state'] = "測驗中";
			}else if( timecmp( $time, strtotime($row[d_test_public]) ) == 1 ){	
				$row['state'] = "已發佈";
			}else if( timecmp( $time, strtotime($row[d_test_public]) ) == -1 ){
				$row['state'] = "未發佈";
			}
			$tpl->append('exam_data', $row);
		}

		$tpl->display("display_exams.tpl");
	}else if(strcmp($option, "delete") == 0){
		$test_no = $_GET['test_no'];
		$sql = "delete from `test_course` where begin_course_cd=$course_cd and test_no=$test_no;";
		$DB_CONN->query($sql);
		$sql = "delete from `test_course_setup` where begin_course_cd=$course_cd and test_no=$test_no;";
		$DB_CONN->query($sql);
		header("location:./tea_view.php");
	}
?>
