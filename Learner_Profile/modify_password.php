<?php
/***
FILE:   
DATE:   2006/12/11
AUTHOR: zqq
**/
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH . "library/passwd.php");
	require_once($RELEATED_PATH . "library/ftp_func.php");
	update_status ( "修改個人資料" );

	//new smartp 
	$tpl = new Smarty();
    
    $input = $_GET;
    //檢查登入
    if(!isset($_SESSION['role_cd']))
        identification_error();
    //檢查只有管理者可以改他人密碼
    if($_SESSION['role_cd'] !=0 
        && isset($input['id']) && $_SESSION['personal_id'] != $input['id'] )
            die('權限錯誤');

    if($_SESSION[role_cd] == 0)
    {
        checkAdmin();
		if(isset($input[id]))
		{
			$personal_id = $input[id];
			$tpl->assign("personal_id_tag1","?id=".$personal_id);
			$tpl->assign("personal_id_tag2","&id=".$personal_id);
		}
		else
		{
			$personal_id = $_SESSION[personal_id];
		}
	}
	else
	{
		$personal_id = $_SESSION[personal_id];
	}
	if($_GET[action] == "modify"){
	  	//先確認密碼是否正確
	  	$sql = "SELECT * FROM register_basic WHERE personal_id=". $personal_id." and pass='".passwd_encrypt($_POST[old_password])."'";
		$res = $DB_CONN->query($sql);
		if (PEAR::isError($res))	die($res->getMessage());			
		$ok = $res->numRows();
		if($ok || ($_SESSION[role_cd] == 0)){
		  	if($_POST[new_password] != $_POST[again_password])
			{
				$tpl->assign("showErr","1");	  
			}
			else if(trim($_POST['new_password']) != "") 
			{
		  		$sql = "UPDATE register_basic SET pass='".passwd_encrypt($_POST[new_password])."', password_hint='$_POST[password_hint]' WHERE personal_id=".$personal_id;
				db_query($sql);
				$sql = "SELECT login_id FROM register_basic WHERE personal_id=$personal_id";
				$login_id = db_getOne($sql);

				//老師需要修改FTP的密碼(如果助教已被指定為某一門課的助教也要修改) 
				$role_cd=db_getOne("SELECT role_cd FROM register_basic WHERE personal_id=$personal_id");
				if($role_cd == 1 || $role_cd == 2)
					modify_ftp_account($login_id, $_POST[new_password],"");
				
				$tpl->assign("showOK","1");	
			}
		}
		else{
			$tpl->assign("showErr","1");
		}	
	}

	$tpl->assign("role_cd",$_SESSION['role_cd']);
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/modify_password.tpl");	
?>
