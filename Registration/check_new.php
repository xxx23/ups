<?php
/***
FILE:   chech_new.php
DATE:   2006/11/26
AUTHOR: zqq

詢問是否第一次註冊的頁面
**/
	require_once("../config.php");

	$tpl = new Smarty();
	//註冊頁面的網址	
	$tpl->assign('registerPage','./register.php');
	//登入個人頁面的網址
	$tpl->assign('personalPage','../Personal_Page/myPage.php');
	$tpl->display("check_new.tpl");
?>
