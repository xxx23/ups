<?php
	/*author: lunsrot
	 * date: 2007/10/17
	 */
	require_once("../config.php");
	require_once("../session.php");

	include "library.php";
	checkAdminAcademic();
	$input = $_GET;
	if(empty($input['option']))
		$input['option'] = "view";
	call_user_func($input['option'], $input);

	//template
	//顯示查詢學生的介面及學生列表
	function view($input){
		$tpl = new Smarty;
		if(!empty($input['rule']))
			search_result($tpl, $input['rule'], $input['arg']);
		assignTemplate($tpl, "/learner_profile/delete_student.tpl");
	}

	//function
	//執行刪除的動作(事先備份資料)，並將畫面導回查詢名單的介面
	function _delete($input){
		global $PERSONAL_PATH;
		$pid = $input['pid'];
		for($i = 0 ; $i < count($pid) ; $i++){
			//刪除相關table(資料量牽涉太大，尚未實作)
			remove_personal_file($PERSONAL_PATH . $pid[$i]);			//刪除檔案
			remove_main_table($pid[$i]);			//刪除三個主要的table: personal_basic, register_basic, take_course
		}
		header("location:./delete_student.php?is_delete=1");
	}

	//function
	function delete_backup($input){
		remove_delete_list();
		header("location:./delete_student.php");
	}

	//library
	//依要求搜尋出符合的學生列表(包括修課列表)
	function search_result($tpl, $rule, $arg){
		$tpl->assign("result", 1);

		$str = "select p.personal_id, p.personal_name, r.login_id from `personal_basic` p, `register_basic` r where r.role_cd=3 and r.personal_id=p.personal_id";
		if($rule == "all")
			$res = db_query($str . " order by p.personal_id;");
		else if($rule == "account")
			$res = db_query($str . " and r.login_id like '%$arg%' order by p.personal_id;");
		else if($rule == "name")
			$res = db_query($str . " and p.personal_name like '%$arg%' order by p.personal_id;");
		while($r = $res->fetchRow(DB_FETCHMODE_ASSOC)){
			$tmp = db_query("select begin_course_name from `begin_course` where begin_course_cd in (select begin_course_cd from `take_course` where personal_id=$r[personal_id]);");
			$course = array();
			while($c = $tmp->fetchRow(DB_FETCHMODE_ASSOC))
				array_push($course, $c['begin_course_name']);
			$r['course'] = $course;
			$tpl->append("data", $r);
		}
	}

	//library
	//將欲刪除的學生資料存入管理者的delete_student_list.xml中，以便日後可以回復
	function backup_file($pid){
		global $DB_CONN, $PERSONAL_PATH;
		$dom = new DOMDocument();
		$path = $PERSONAL_PATH . $_SESSION['personal_id'];
		if( file_exists($path . "/delete_student_list.xml") == false)
			create_delete_list($path);
		$dom->load($path . "/delete_student_list.xml");
		$parent = $dom->getElementsByTagName("delete_list")->item(0);

		for($i = 0 ; $i < count($pid) ; $i++){
			$element = new DOMElement("person");
			//此處需注意，在未將<person>加入<delete_list>之前，<person>是無法appendChild的
			$parent->appendChild($element);

			$per = $DB_CONN->getRow("select * from `personal_basic` where personal_id=$pid[$i];", DB_FETCHMODE_ASSOC);
			create_element($element, "personal", $per);

			$reg = $DB_CONN->getRow("select * from `register_basic` where personal_id=$pid[$i];", DB_FETCHMODE_ASSOC);
			create_element($element, "register", $reg);

			$tmp = db_query("select begin_course_cd from `take_course` where personal_id=$pid[$i];");
			$course = array();
			while($id = $tmp->fetchRow())
				array_push($course, $id[0]);
			create_element($element, "course", $course);
		}
		$dom->save($path . "/delete_student_list.xml");
	}

	//library
	//確定備份檔案是否存在，若無則產生
	function create_delete_list($path){
		if( is_dir($path) == false)
			createPath($path);
		$f = fopen($path . "/delete_student_list.xml", "w");
		fwrite($f, "<delete_list>\n");
		fwrite($f, "</delete_list>");
		fclose($f);
	}

	//library
	//三個主要table的儲存函式
	function create_element($element, $type, $data){
		$dom = new DOMElement($type);
		$element->appendChild($dom);
		$str = "";
		foreach($data as $k => $v)
			$str = $str . "$k=$v\n";
		$dom->appendChild(new DOMText($str));
	}

	//library
	//刪除學生的個人資料夾
	function remove_personal_file($path){
		if(is_dir($path) == false)
			return ;
		$dir = opendir($path);
		while($file = readdir($dir)){
			if(is_dir($path . "/" . $file) && $file != "." && $file != "..")
				remove_personal_file($path . "/" . $file);
			else if($file != "." && $file != "..")
				unlink($path . "/" . $file);
		}
		rmdir($path);
		return ;
	}

	//library
	function remove_main_table($pid){
		db_query("delete from `take_course` where personal_id=$pid;");
		db_query("delete from `personal_basic` where personal_id=$pid;");
		db_query("delete from `register_basic` where personal_id=$pid;");
	}
?>
