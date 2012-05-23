<?php
	/*author: lunsrot
	 * date: 2007/08/09
	 * 一些線上作業會用到的函式，可以將線上作業的角色分成兩種：出作業的人和回答作業的人
	 */
	//非interactive的錯誤
	function localError($msg){
		echo "在$msg發生錯誤<br/>";
		exit(0);
	}

	//檢視線上作業列表
	function listAssignment($course_cd, $type){
		$sql = "select homework_no, homework_name, question, percentage, late,  d_dueday, ans_day, public 
			from `homework` where begin_course_cd=$course_cd and is_co_learn=0";
		if($type == "all")
			$sql .= ";";
		else if($type == "public")
			$sql .= " and public>1;";
		else
			localError("listAssignment");
		return db_query($sql);
	}

	//檢視線上作業
	function viewAssignment($ass_no, $role){
		global $DB_CONN, $COURSE_FILE_PATH, $WEBROOT;
		$tpl = new Smarty;
		$input = $_GET;
        
		$row = $DB_CONN->getRow("select homework_name, question, q_type, begin_course_cd from `homework` where homework_no=$ass_no;", DB_FETCHMODE_ASSOC); 
        $tpl->assign('name', $row['homework_name']);
		$file_path = $COURSE_FILE_PATH . $row['begin_course_cd'] . "/homework/$ass_no/teacher/question/";


        
		//需在修改作業內容前決定相關檔案
		$file_data = _downloadRelativeFile($file_path, $row['question']);

		//作業題目呈現方式
		if(!empty($row['q_type'])){		//上傳檔案者
			$row['question'] = "<a href=\"{$WEBROOT}library/redirect_file.php?file_name=" . urlencode($row['question']) . "\">" . $row['question'] . "</a>";
		}else if($input['math'] != 1){		//非上傳檔案且不需方程式編輯器者
			$input['math'] = 0;
		}
		$tpl->assign("math", $input['math']);

		$tpl->assign('question', $row['question']);
		$tpl->assign("file_data", $file_data);
		$tpl->assign("homework_no", $ass_no);

		//依身份決定是否可以連結修改頁面
		$tpl->assign("role", $role);

		assignTemplate($tpl, "/assignment/question_view.tpl");
	}

	//列出相關檔案，檢視作業和學生的回答都有可能用到
	//file_path是指檔案資料夾的路徑，file則是某一個檔案名稱。
	//在列出檔案時，會略過file
	function _downloadRelativeFile($file_path, $file){
		if(is_dir($file_path) != 1)
			return ;
		$_SESSION['current_path'] = $file_path;
		$list = array();
		$d = dir($file_path);
		while($entry = $d->read()){
			if(is_dir($entry) == false && $entry != $file){
				$tmp = array();
				$tmp['name'] = $entry;
				$tmp['path'] = urlencode($entry);
				array_push($list, $tmp);
			}
		}
		return $list;
	}
?>
