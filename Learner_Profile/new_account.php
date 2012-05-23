<?php
/***
FILE:新增帳號 , 如果是老師帳號則需要新增ftp 
DATE:2009/06/25
AUTHOR:tgbsa

update:2009/12/27
editor: arnan
**/

require_once('../config.php');
require_once('../session.php');
checkAdmin();
require_once('../library/ftp_func.php');
require_once('../library/account.php');
require_once('../library/filter.php');
//new smarty
$tpl = new Smarty();

$account_name 	= trim($_POST['account_name']); 
$password 		= $_POST['password'] ; 
$role_cd		= optional_param('role', 3 , PARAM_INT) ;  //沒搞好就預設角色為學生
$dist_cd        = $_POST['selRole'] ;
//新增教務管理者	
if(array_key_exists('action', $_GET) && $_GET['action']=='new'){
	if($account_name == '' || $account_name == NULL){
		$tpl->assign('MSG', "教務管理者帳號未輸入");
	}
	else{
		if( !validate_login_id( $account_name )  ){
			$tpl->assign('MSG',  "帳號不可含有特殊字元");
			$tpl->assign("valueOfAccount_name", $account_name);
			$tpl->assign("valueOfPassword", $password );
		}
		else if(check_login_id( $account_name ) == 1){
			$tpl->assign('MSG' ,  "帳號已經存在" );
			$tpl->assign("valueOfAcademic_admin_name", $account_name );
			$tpl->assign("valueOfPassword", $password );
		}
		else{ //新增成功
			$account_cd = create_account( $account_name, $password, $role_cd);
			if($account_cd == -1)
				exit(0);
				
			//更新使用者資訊
			$sql = "UPDATE register_basic set login_state='1', validated='1', d_loging=NOW() where personal_id=$account_cd" ;
			db_query($sql);
			
			$tpl->assign('MSG' , "新增使用者帳號 $account_name 成功" );
			$sql = "UPDATE personal_basic SET personal_name='$account_name' , dist_cd='$dist_cd'  WHERE personal_id=$account_cd ";
			db_query($sql);
				
			//如果是教師帳號 , 新增教師資料夾 及新增ftp 帳號
			if( 1 == $role_cd ) {
				createTeacherDIR($account_cd);	
				new_ftp_account( $account_name , $password, '' );				
			}
		    //	header('Location: new_account.php');
		}
	}

}
//輸出頁面
assignTemplate($tpl, "/learner_profile/new_account.tpl");
?>
