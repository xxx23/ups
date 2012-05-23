<?php
	/*author: lunsrot
	 * date: 2007/08/23
	 */
	require_once("../config.php");
	require_once("../session.php");
	require_once("../library/account.php");
	require_once("../library/passwd.php");
	require_once("../library/mail.php");
	include "library.php";

	checkMenu("/Learner_Profile/manage_course_assistant.php?option=list_assistants");

	$input = $_GET;
	call_user_func($input['option'], $input);

	//template
	//教師新增、修改助教的介面
	function view_modify($input){
		global $DB_CONN , $HOME_PATH;
		$tpl = new Smarty;

		if(!empty($input['done']))
			$tpl->assign("done", 1);

		$p_data = array();
		$p_data['action_type'] = "create";
		if(!empty($input['login_id'])){
			$p_data = $DB_CONN->getRow("select p.personal_id, p.personal_name, p.email, p.tel, r.login_id, r.pass from `personal_basic` p, `register_basic` r where r.login_id='$input[login_id]' and p.personal_id=r.personal_id;", DB_FETCHMODE_ASSOC);
			$p_data['pass'] = passwd_decrypt($p_data['pass']);
			$p_data['action_type'] = "modify";
		}

		if($p_data['action_type'] == "create" && $DB_CONN->getOne("select count(*) from `teach_aid` where teacher_cd=$_SESSION[personal_id];") != 0)
			select_assistant($tpl);
 
		$tpl->assign("person", $p_data);
		
		assignTemplate($tpl, "/learner_profile/modify_course_assistant.tpl");
	}

	//template
	//教師檢視助教列表
	function list_assistants($input){
		$tpl = new Smarty;

		if(!empty($input['done']))
			$tpl->assign("done", 1);
		
		$p_data = db_query(fetch_course_assist()); 
		while($r = $p_data->fetchRow(DB_FETCHMODE_ASSOC)){
			$r['pass'] = passwd_decrypt($r['pass']);
			$tpl->append("data", $r);
		}

		assignTemplate($tpl, "/learner_profile/list_course_assistants.tpl");
	}

	//function
	//教師新增助教
	function create($input){
		global $DB_CONN;

		$flag = (check_login($input['login_id']) == 1) ? "new" : "previous";
		$p_flag = check_information($input);
		if($p_flag == 1)
 			$input['password'] = random_password();

		if($flag == "new"){
			$pid = create_account($input['login_id'], $input['password'], 2);
			$teacher_cd = getTeacherId();
			db_query("insert into `teach_aid` (teacher_cd, if_aid_teacher_cd) values ($teacher_cd, $pid);");
			db_query("update `register_basic` set login_state='1' , validated='1' where personal_id=$pid;");
		}else{
			$pid = $DB_CONN->getOne("select personal_id from `register_basic` where login_id='$input[login_id]';");
		}
		$input['pid'] = $pid;
		mailto("","CyberCCU2",$input['email'],"助教密碼",$input['user_name']." 您好，以下是您的助教帳號與密碼:<br>助教帳號：".$input['login_id']."
		  <br>助教密碼:".$input['password']);
		update_register($input);
		update_personal($input);
        //助教 ftp config
        update_ftp($input,$flag); 


		db_query("insert into `teach_begin_course` (teacher_cd, begin_course_cd, course_master) values ($pid, $_SESSION[begin_course_cd], '0');");
		//需寄信通知助教課程及密碼
		header("location:./manage_course_assistant.php?option=view_modify&done=1");
 	}

	//function
	//教師移除助教帳號，並非真的移除資料，僅是從此門課中減少助教
	function remove($input){
        global $DB_CONN;
             foreach($input['id'] as $id){  
               db_query("delete from `teach_begin_course` where teacher_cd=$id;");  
               //取得助教登入帳號  
               $login_id = $DB_CONN->getOne("select login_id from `register_basic` where personal_id='$id';");  
               //刪除助教的ftp帳號    
                db_query("delete from `users` where User='{$login_id}';");  
             }  
		header("location:./manage_course_assistant.php?option=list_assistants&done=1");
	}

	//function
	//教師修改助教資料
	function modify($input){
		$p_flag = check_information($input);
		if($p_flag == 1)
		  $input['password'] = random_password();

		mailto("","CyberCCU2",$input['email'],"助教密碼","您好，以下是您的助教密碼:<br>密碼:".$input['password']);
		update_register($input);
		update_personal($input);
		header("location:./manage_course_assistant.php?option=list_assistants&done=1");
	}

	//library
	//檢查login_id是否可用
	function check_login($id){
		global $DB_CONN;
		if(empty($id))
		  	error_msg("請輸入助教帳號！");

		if(!validate_login_id($id))
		  	error_msg("助教帳號不可以含有特殊字元");

		//該帳號不存在
		$tmp = db_query("select personal_id from `register_basic` where login_id='$id';");
		$num = $tmp->numRows();
		if($num == 0)
			return 1;
		//該帳號已為此課程的助教
		$p = $tmp->fetchRow(DB_FETCHMODE_ASSOC);
		$num = $DB_CONN->getOne("select count(*) from `teach_begin_course` where begin_course_cd=$_SESSION[begin_course_cd] and teacher_cd=$p[personal_id];");
		if($num != 0)
			error_msg("該帳號已為本課程助教之一！");
		//該助教屬於此教師
		$num = $DB_CONN->getOne("select count(t.teacher_cd) from `teach_aid` t, `register_basic` r where teacher_cd=$_SESSION[personal_id] and r.personal_id=t.if_aid_teacher_cd and r.login_id='$id';");
		if($num != 0)
			return 0;
		error_msg("該帳號已存在，請重新輸入！");
	}

	//library
	//檢查其他資料是否有誤
	//若教師有決定密碼則回傳0，若教師無指定密碼則回傳1，表示需亂數產生
	function check_information($input){
		if(empty($input['user_name']))
			error_msg("請填寫助教名稱！");
		if(empty($input['email']))
			error_msg("請填寫助教的電子郵件！");
		if(empty($input['phone']))
			error_msg("請填寫助教的連絡電話！");
		if(empty($input['password']) && !is_numeric($input['password']))
			return 1;
		return 0;
	}

	//library
	//亂數產生密碼
	function random_password(){
		$output = "";
		for($i = 0 ; $i < 8 ; $i++)
			$output .= rand() % 9;
		return $output;
	}

	//library
	function update_register($input){
		$input['password'] = passwd_encrypt($input['password']);
		db_query("update `register_basic` set pass='$input[password]', role_cd=2 where login_id='$input[login_id]' and personal_id=$input[pid];"); 
	}

	//library
	function  update_personal($input){
		db_query("update `personal_basic` set personal_name='$input[user_name]', email='$input[email]', tel='$input[phone]', identify_id='0',dist_cd='2' where personal_id=$input[pid];");
	}
    //library
    function  update_ftp($input,$flag){  
           global $DB_CONN , $HOME_PATH;  
            if($flag == $new){  
            $teacher_cd = getTeacherId();  
            db_query("insert into `users` (User,Password,Uid,Gid,Dir) values('{$input['login_id']}',MD5('{$input['password']}'),'80','80','{$HOME_PATH}Data_File/{$teacher_cd}/');");  
            }else{  
                       $teacher_cd = getTeacherId();  
                       db_query("insert into `users` (User,Password,Uid,Gid,Dir) values('{$input['login_id']}',MD5('{$input['password']}'),'80','80','{$HOME_PATH}Data_File/{$teacher_cd}/');");  
                       //更新ftp password  
                       db_query("update `users` set Password=MD5('$input[password]') where User='{$input['login_id']}'");  
                   }  
     }  
	//library
	//錯誤訊息提示
	function error_msg($str){
		echo "<script type=\"text/javascript\">alert('$str');history.back();</script>";
		exit(0);
	}

	//library
	//顯示該教師已有的助教給教師選擇
	function select_assistant($tpl){
		$tpl->assign("select", 1);
		$p_data = db_query(fetch_all_assist()); 
		while($r = $p_data->fetchRow(DB_FETCHMODE_ASSOC)){
			$r['pass'] = passwd_decrypt($r['pass']);
			$tpl->append("data", $r);
		}
	}

	//library
	//列出該課程的助教
	function fetch_course_assist(){
		return "select p.personal_id, p.personal_name, p.email, p.tel, r.login_id, r.pass from `personal_basic` p, `register_basic` r where r.personal_id in (select teacher_cd from `teach_begin_course` where begin_course_cd={$_SESSION['begin_course_cd']}) and p.personal_id=r.personal_id and r.role_cd=2;";
	}
?>
