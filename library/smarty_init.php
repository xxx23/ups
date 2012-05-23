<?php 

//注意此
require_once('../config.php');
require_once('../session.php'); 
require_once('Smarty.class.php');

//可在其他php被使用
global $tpl; 

$tpl = new Smarty; 

//做一些調整設定

//將smarty compile過得資料指到同一個，不必再每個資料夾有一個 templates_c ，而是集中到一個
$tpl->compile_dir = $HOME_PATH . 'templates_c'; 

//templates_c 將會有sub directory ( performance issue )
$tpl->use_sub_dirs = true ;

//利用smarty的config檔功能 最為設定語言檔目錄
$tpl->config_dir	= get_lang_path() ; 

$tpl->assign("HOME_PATH", $HOME_PATH);
//使用本 smarty_init的方法

//將原本每頁  $tpl = new Smarty ; 的方式改成 
//require_once($HOME_PATH.'library/smarty_init.php') ; 
//當 include smarty_init.php 後就可以使用 $tpl 當預設變數


//語系 給.tpl的圖片 css用
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
