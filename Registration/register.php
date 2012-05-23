<?php
/***
FILE:   register.php
DATE:   2006/11/26
AUTHOR: zqq
MODIFIER :tgbsa
註冊帳號的頁面
**/
require_once("../config.php");
require_once($HOME_PATH . 'library/smarty_init.php');
//開啟session
session_start();

//看註冊身份設定新增時的身份
//參考table lrtrole_的身份數字 教師:1 , 學生:3 
if( $_GET['t'] == 'tea' ) { 
	$_SESSION['role_type'] ='1' ; 
}
if( $_GET['t'] == 'stu' ) {
	$_SESSION['role_type'] ='3' ; 
}

if(!isset($_SESSION['agree'])){
  echo "請依正確流程瀏覽網頁";
  exit(0);
}
//session變數
if(!isset ($_SESSION['values']) ){
	$_SESSION['values']['txtUsername'] = '';
	$_SESSION['values']['txtPassword'] = '';
	$_SESSION['values']['txtCkPassword'] = '';
	$_SESSION['values']['txtPasswordInfo'] = '';
}

if (!isset ($_SESSION['errors'] ) ) //第一次進來這個頁面
{
	$_SESSION['errors']['txtUsername'] = 'hidden';	
	$_SESSION['errors']['txtPassword'] = 'hidden';
	$_SESSION['errors']['txtCkPassword'] = 'hidden';
    $_SESSION['errors']['txtPasswordInfo'] = 'hidden';
    $_SESSION['errors']['checked'] = false;
}
else if(isset ($_SESSION['errors']))
{
    if($_SESSION['errors']['checked'] == true) //從驗證頁面 如果有驗證錯誤 就回來
    {
        $_SESSION['errors']['checked'] = false;
    }
    else //有填寫過這個頁面 然後後來又從首頁點選加入會員進來的話 就把值拿掉
    {
        $_SESSION['errors']['txtUsername'] = 'hidden';	
        $_SESSION['errors']['txtPassword'] = 'hidden';
        $_SESSION['errors']['txtCkPassword'] = 'hidden';
        $_SESSION['errors']['txtPasswordInfo'] = 'hidden';
        $_SESSION['values']['txtUsername'] = '';
        $_SESSION['values']['txtPassword'] = '';
        $_SESSION['values']['txtCkPassword'] = '';
        $_SESSION['values']['txtPasswordInfo'] = '';
    }
}



//$tpl = new Smarty();
//註冊狀態的圖
$IMAGE_PATH = "../" . $IMAGE_PATH;
$tpl->assign("registerState", $IMAGE_PATH . "register_1.PNG");

//user name
$tpl->assign("valueOfUsername",$_SESSION['values']['txtUsername']);
$tpl->assign("txtUsernameFailed",$_SESSION['errors']['txtUsername']);

//ShowCkPassword
$tpl->assign("txtShowCkPasswordFailed",$_SESSION['correct']['txtShowCkPassword']);

//password 
$tpl->assign("valueOfPassword",$_SESSION['values']['txtPassword']);
$tpl->assign("txtPasswordFailed",$_SESSION['errors']['txtPassword']);	
//check password
$tpl->assign("valueOfCkPassword",$_SESSION['values']['txtCkPassword']);
$tpl->assign("txtCkPasswordFailed",$_SESSION['errors']['txtCkPassword']);
//password info.
$tpl->assign("valueOfPasswordInfo",$_SESSION['values']['txtPasswordInfo']);
$tpl->assign("txtPasswordInfoFailed",$_SESSION['errors']['txtPasswordInfo']);

$tpl->display("register.tpl");

?>
