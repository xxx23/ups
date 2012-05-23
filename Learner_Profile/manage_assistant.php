<?php
	/*author: lunsrot
	 * date: 2007/08/25
	 */
	require_once("../config.php");
	require_once("../session.php");
	include "library.php";
	include "../library/account.php";

	checkMenu("/Learner_Profile/manage_course_assistant.php?option=list_assistants");

	$input = $_GET;
	call_user_func($input['option'], $input);

	//template
	//教師檢視所有助教的介面
	function list_assistants($input){
		$tpl = new Smarty;

		$p_data = db_query(fetch_all_assist()); 
		while($r = $p_data->fetchRow(DB_FETCHMODE_ASSOC)){
			$r['pass'] = passwd_decrypt($r['pass']);
			$tpl->append("data", $r);
		}

		assignTemplate($tpl, "/learner_profile/list_assistants.tpl");
	}

	//template
	//教師設定助教權限的介面
	function view_set($input){
		$tpl = new Smarty;
		$set = func_list(1, null, 0, 3);
		$tpl->assign("done", $input['done']);
		$tpl->assign("level_0", $set);
		assignTemplate($tpl, "/learner_profile/function.tpl");
	}

	//function
	//教師設定助教權限
	function set($input){
	  
		$course_cd = $_SESSION['begin_course_cd'];
		insert($course_cd);
		db_query("update `menu_role` set is_used='n' where role_cd=2 and begin_course_cd=$course_cd;");
		foreach($input['menu_0'] as $m0){
			setUesable($course_cd, $m0);
			foreach($input['menu_' . $m0] as $m1){
				setUesable($course_cd, $m1);
				for($i = 0 ; $i < count($input['menu_'. $m1]) ; $i++)
					setUesable($course_cd, $input['menu_' . $m1][$i]);
			}
		}
		header("location:./manage_assistant.php?option=view_set&done=1");
	}

	//library
	//列出教師權限
	function func_list($role, $like, $lvl, $stop){
		$begin_course_cd = $_SESSION['begin_course_cd'];
        
        if($lvl >= $stop)
			return ;
		$sql = "select A.menu_id, B.menu_name, B.menu_link from `menu_role` A, `lrtmenu_` B where A.menu_id=B.menu_id and A.role_cd=$role and A.is_used='y' and B.menu_level=$lvl ";
		if($like != null)
			$sql = $sql . "and B.menu_id like '" . $like . "%' ";
		$sql = $sql . "order by B.sort_id;";

		$result = db_query($sql);

        //助教目前的有的權限(used設為y)列表
        $sql = "select menu_id from `menu_role` where begin_course_cd='$begin_course_cd' and role_cd=2 and is_used='y';";
		$used_list = array();
		$tmp = db_query($sql);
		while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC)){
            array_push($used_list, $r['menu_id']);
        }
		$i = 0;
		$set = array();
		while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			$set[$i] = $row;
			$set[$i]['next'] = func_list($role, $row['menu_id'], $lvl+1, $stop);

            if(in_array($set[$i]['menu_id'],$used_list))
                $set[$i]['is_used'] = 'y';

			$i++;
		}

		return $set;
	}

	//library
	//為此課程的助教新增所有的entry
	function insert($course_cd){
		//教師的權限列表
		$tmp = db_query("select menu_id from `menu_role` where role_cd=1;");
		$tea = array();
		while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($tea, $r['menu_id']);
		//助教目前的權限列表
		$tmp = db_query("select menu_id from `menu_role` where begin_course_cd=$course_cd and role_cd=2;");
		$ass = array();
		while($r = $tmp->fetchRow(DB_FETCHMODE_ASSOC))
			array_push($ass, $r['menu_id']);
		//助教目前缺少的權限列表
		$res = array_diff($tea, $ass);
		foreach($res as $id)
			db_query("insert into `menu_role` (menu_id, role_cd, is_used, begin_course_cd) values ('$id', 2, 'n', $course_cd);");
	}

	//library
	//將助教的特定權限設為yes
	function setUesable($course_cd, $m){
		db_query("update `menu_role` set is_used='y' where role_cd=2 and begin_course_cd=$course_cd and menu_id='$m';");
	}
?>
