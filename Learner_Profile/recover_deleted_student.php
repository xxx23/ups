<?php
	/*author: lunsrot
	 * date: 2007/10/18
	 */
	require_once("../config.php");
	require_once("../session.php");
	checkAdminTeacherTa();

	include "library.php";

	$input = $_GET;
	if(empty($input['option']))
		$input['option'] = "view";
	call_user_func($input['option'], $input);

	//template
	function view($input){
		global $PERSONAL_PATH;
		$tpl = new Smarty;
		$path = $PERSONAL_PATH . $_SESSION['personal_id'];
		if( file_exists($path . "/delete_student_list.xml") == true)
			recover_person_view($tpl, $path . "/delete_student_list.xml");
		assignTemplate($tpl, "/learner_profile/recover_deleted_student.tpl");
	}

	//function
	function recover($input){
		global $PERSONAL_PATH;
		$meta = get_data($PERSONAL_PATH . $_SESSION['personal_id'] . "/delete_student_list.xml");
		$data = array();

		//將不可回復的資料濾掉
		for($i = 0 ; $i < count($meta) ; $i++){
			$tmp = $meta[$i];
			$r = array("personal_id" => $tmp['personal']['personal_id'], "personal_name" => $tmp['personal']['personal_name'], "login_id" => $tmp['register']['login_id']);
			if( is_recoverable($tmp['personal'], $tmp['register']) == true )
				array_push($data, $meta[$i]);
		}

		//回復資料
		for($i = 0 ; $i < count($data) ; $i++){
			//personal_basic
			db_query(recover_string("personal", $data[$i]['personal']));
			//register_basic
			db_query(recover_string("register", $data[$i]['register']));
			//take_course, 和上兩個table不同，需特殊處理
			recover_take_course($data[$i]['course'], $data[$i]['personal']['personal_id']);
		}

		remove_delete_list();
		header("location:./recover_deleted_student.php?done=1");
	}

	//library
	function recover_person_view($tpl, $file){
		$data = get_data($file);

		$err = array();
		for($i = 0 ; $i < count($data) ; $i++){
			$tmp = $data[$i];
			$r = array("personal_id" => $tmp['personal']['personal_id'], "personal_name" => $tmp['personal']['personal_name'], "login_id" => $tmp['register']['login_id']);
			if( is_recoverable($tmp['personal'], $tmp['register']) == true )
				$tpl->append("data", $r);
			else
				array_push($err, $r);
		}

		if(count($err) != 0){
			$tpl->assign("is_error", 1);
			$tpl->assign("err_data", $err);
		}
	}

	//libray
	//將所需的資料從xml檔案中取出，並parse成可用的格式
	function get_data($file){
		$output = array();
		$dom = new DOMDocument();
		$dom->load($file);
		$parent = $dom->getElementsByTagName("delete_list")->item(0);
		$per = $parent->getElementsByTagName("personal");
		$reg = $parent->getElementsByTagName("register");
		$cou = $parent->getElementsByTagName("course");

		for($i = 0 ; $i < $per->length ; $i++){
			$per_data = grep_data($per->item($i)->nodeValue);
			$reg_data = grep_data($reg->item($i)->nodeValue);
			$cou_data = grep_data($cou->item($i)->nodeValue);
			$tmp = array();
			$tmp['personal'] = $per_data;
			$tmp['register'] = $reg_data;
			$tmp['course'] = $cou_data;
			array_push($output, $tmp);
		}
		return $output;
	}

	//library
	//將檔案中的資料作parse
	function grep_data($str){
		$out = array();
		//原先資料以行為單位，其內容為ex: personal_id=123
		$tmp = split("\n", $str);
		for($i = 0 ; $i < count($tmp) ; $i++){
			if(empty($tmp[$i]))
				continue;
			$tmp2 = split("=", $tmp[$i]);
			if(count($tmp2) != 2)
				continue;
			$out[ $tmp2[0] ] = $tmp2[1];
		}
		return $out;
	}

	//library
	//確認此帳號是否可以回復
	function is_recoverable($per, $reg){
		$tmp = db_query("select * from `personal_basic` where personal_id=$per[personal_id];");
		if($tmp->numRows() != 0)
			return false;
		$tmp = db_query("select * from `register_basic` where login_id='$reg[login_id]';");
		if($tmp->numRows() != 0)
			return false;
		return true;
	}

	//library
	function recover_string($table, $in){
		$output = "insert into `$table" . "_basic` (";
		$key = "";
		$value = "";

		foreach($in as $k => $v){
			$key .= "$k, ";
			if(is_numeric($v))
				$value .= "$v, ";
			else
				$value .= "'$v', ";
		}
		$key = substr($key, 0, strlen($key) - 2);
		$value = substr($value, 0, strlen($value) - 2);

		$output .= "$key) values ($value);";
		return $output;
	}

	//library
	function recover_take_course($course, $id){
	  	for($i = 0 ; $i < count($course) ; $i++)
	  	{
		  	db_query("insert into `take_course` (begin_course_cd, personal_id) values ($course[$i], $id);");
			sync_stu_course_data($course[$i],$id);
		}

	}
?>
