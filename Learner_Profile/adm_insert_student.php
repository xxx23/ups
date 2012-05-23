<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/ftp_func.php");
	require_once($RELEATED_PATH . "library/account.php");
	require_once($HOME_PATH . 'library/smarty_init.php');
	//update_status ( "確認開課中" );

	global $PERSONAL_PATH;
	global $DATA_FILE_PATH;
	checkAdminAcademic();
	//new smarty
	//$tpl = new Smarty();

	if(array_key_exists('action', $_GET) && $_GET['action'] == 'create'){
		$tpl->assign("create", 1);
		for($i=0; $i < $_POST['num']; $i++){
			//判斷帳號是否存在
			$login_id = trim($_POST['id']) . $i;
			$passwd = $_POST['passwd'] . $_POST['id'] . $i;
			$role_cd = $_POST['role'];
			if(!validate_login_id($login_id)){
				$error_list['id'] = $login_id;
				$error_list['reason'] = "帳號含有不合法字元";
				$tpl->append("error_list", $error_list);
			}else if(check_login_id($login_id) == 1){
				$error_list['id'] = $login_id;
				$error_list['reason'] = "帳號已經存在";
				$tpl->append("error_list", $error_list);
			}
            else{
                if($_POST['student_dist'] != -1)// 表示有選擇
                    $dist_cd = $_POST['student_dist'];
                else
                    $dist_cd = 0 ;
                //如果沒有選擇的話，就預設為一般民眾
				$personal_id = create_account($login_id,$passwd,$role_cd);
				//加入 personal_basic
				$sql = "UPDATE personal_basic SET identify_id=0, personal_name='".$login_id."', personal_style='IE2', dist_cd='{$dist_cd}' WHERE personal_id=".$personal_id;
				$res = db_query($sql);

				$sql = "UPDATE register_basic set login_state='1', validated='1' where personal_id=$personal_id";
				$res = db_query($sql);

				//若是老師建老師的課程資料夾
                                if($role_cd == 1)
				{
					createTeacherDIR( $personal_id);
					new_ftp_account( $login_id , $passwd, '' );
				}
				$data_list['index'] = $i;
				$data_list['id'] = $login_id;
				$data_list['passwd'] = $passwd;
				$tpl->append("data_list", $data_list);
			}
		}
	}




	$sql = "SELECT * FROM lrtrole_ ";
	$res = db_query($sql);
	$i = 0;
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$role[$i]['id'] = $row['role_cd'];
		$role[$i++]['name'] = $row['role_name'];
	}
	$tpl->assign("roles", $role);
	$tpl->assign("user_role",$_SESSION['role_cd']);
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/adm_insert_student.tpl");


?>
