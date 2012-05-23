<?php 
//確認是否是可登入之帳號
include('../config.php'); 
include('../library/filter.php');
include('lib.php');  

$logout = optional_param('logout', 'false', PARAM_TEXT) ; 

if( $logout == 'true') {
	session_start(); 
	$_SESSION = array() ;
	session_destroy();
	redirect('login.php') ; 
	return ;
}

$account = required_param('account', PARAM_TEXT ) ; 
$password = required_param('password', PARAM_TEXT );


$check_account_exist = " SELECT * FROM register_applycourse WHERE account='$account' AND password=md5('$password') AND state = 1"; 
$row = db_getRow($check_account_exist);


//此帳號存在
if( !empty($row)  ) {
	session_start(); 
	$_SESSION['menu_role'] = json_decode($row['menu_role']);
	$_SESSION['no'] = $row['no']; 
	$_SESSION['category'] = $row['category'];
	
	$update_login_date = " UPDATE register_applycourse SET login_date=NOW() WHERE no=". $row['no'] ;
	db_query($update_login_date) ;
	
	redirect('login_page.php');
	return ;
}else { //不存在
	;
	redirect('login.php');
	
}





?>