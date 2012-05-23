<?php 

//�`�N��
require_once('../config.php');
require_once('../session.php'); 
require_once('Smarty.class.php');

//�i�b��Lphp�Q�ϥ�
global $tpl; 

$tpl = new Smarty; 

//���@�ǽվ�]�w

//�Nsmarty compile�L�o��ƫ���P�@�ӡA�����A�C�Ӹ�Ƨ����@�� templates_c �A�ӬO������@��
$tpl->compile_dir = $HOME_PATH . 'templates_c'; 

//templates_c �N�|��sub directory ( performance issue )
$tpl->use_sub_dirs = true ;

//�Q��smarty��config�ɥ\�� �̬��]�w�y���ɥؿ�
$tpl->config_dir	= get_lang_path() ; 

$tpl->assign("HOME_PATH", $HOME_PATH);
//�ϥΥ� smarty_init����k

//�N�쥻�C��  $tpl = new Smarty ; ���覡�令 
//require_once($HOME_PATH.'library/smarty_init.php') ; 
//�� include smarty_init.php ��N�i�H�ϥ� $tpl ��w�]�ܼ�


//�y�t ��.tpl���Ϥ� css��
if( isset($_SESSION['lang']) ) {
	$tpl->assign("LANG", $_SESSION['lang']) ;
}else {
	$tpl->assign("LANG", 'zh_tw') ;
}



function get_lang_path() {
	global $HOME_PATH ; 
	session_start(); 
	$ret_str = '';
	
	$lang = 'zh_tw'; //default lang 
	if( $_SESSION['lang'] ) {
		$lang = $_SESSION['lang'] ; 
	}
	
	$ret_str = $HOME_PATH .'lang'. DIRECTORY_SEPARATOR. $lang .DIRECTORY_SEPARATOR ; 
	
	if( !is_dir($ret_str ) ) {
		die("lang directory doesn't exist");
	}
	
	return $ret_str; 
}
?>
