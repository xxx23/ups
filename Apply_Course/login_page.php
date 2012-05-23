<?php 
//登入後的頁面 為兩欄式 以iframe 設定為右邊邊內容頁
//左頁的選單由登入帳號的menu欄位控制 
require_once('../config.php');
require_once('session.php') ;  //確認是否已經login 
require_once('lib.php') ;

//well_print($_SESSION); 

$tpl = new Smarty; 
$no = $_SESSION['no'] ; 

$sql_get_account_info = " SELECT * FROM register_applycourse WHERE no=". $no ; 
$account_data = db_getRow($sql_get_account_info) ; 

$test_arr = filter_menu_ctrl($all_menu_ctrl, $default_menu_group_str, json_decode($account_data['menu_role']) );


$tpl->assign('default_page', $_SESSION['menu_role'][0].'.php'); 


$tpl->assign('account', $account_data['account']) ; 
$tpl->assign('org_title', $account_data['org_title']) ; 
$tpl->assign('menu_ctrl' , $test_arr);

echo "<br/>";

assignTemplate($tpl, '/apply_course/login_page.tpl'); 
?>
