<?php
/***
FILE:   chech_new.php
DATE:   2006/11/26
AUTHOR: zqq

�߰ݬO�_�Ĥ@�����U������
**/
	require_once("../config.php");

	$tpl = new Smarty();
	//���U���������}	
	$tpl->assign('registerPage','./register.php');
	//�n�J�ӤH���������}
	$tpl->assign('personalPage','../Personal_Page/myPage.php');
	$tpl->display("check_new.tpl");
?>
