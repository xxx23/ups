<?php
	/*author: lunsrot
	 * date: 2007/11/15
	 */
	require_once("../config.php");
	require_once("../session.php");

	//library
	//依begin_course_cd找出修該門課的人數，若query失敗，則return -1;
	function member_num_course($cd){
		global $DB_CONN;
		$num = $DB_CONN->getOne("select count(*) from `take_course` where begin_course_cd=$cd and allow_course=1 and status_student=1;");
		if(!is_numeric($num))
			return -1;
		return $num;
	}

	//library
	//依begin_course_cd找出修該門課的personal_id list;
	function member_course($cd){
		$res = db_query("select personal_id from `take_course` where begin_course_cd=$cd and allow_course=1 and status_student=1;");
		$output = array();
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($output, $r['personal_id']);
		return $output;
	}

	//library
	//依名單回傳另一個array，格式為output中的每一個element表示一個學生，每個element各紀錄相關資訊
	function people_informations($list){
		$output = array();
		for($i = 0 ; $i < count($list) ; $i++)
			array_push($output, person_information($list[$i]));
		return $output;
	}

	//library
	//因不確定個人資料需要哪些，所以將其分成函式，以便日後修改
	function person_information($pid){
		global $DB_CONN;
		return $DB_CONN->getRow("select p.personal_id, r.login_id, p.personal_name from `register_basic` r, `personal_basic` p where r.personal_id=p.personal_id and p.personal_id=$pid;", DB_FETCHMODE_ASSOC);
	}

	//library
	//依課程名稱取得begin_course_cd
	function get_course_cd_by_name($name){
		$res = db_query("select begin_course_cd from `begin_course` where begin_course_name like '%$name%';");
		$output = array();
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($output, $r['begin_course_cd']);
		return $output;
	}

	//library
	//取得所有課程的begin_course_cd
	function get_all_course_cd(){
		$res = db_query("select begin_course_cd from `begin_course` where 1;");
		$output = array();
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($output, $r['begin_course_cd']);
		return $output;
	}
?>
