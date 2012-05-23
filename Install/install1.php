<?php 
	//error_reporting(E_ALL);
	
	// do include smarty 
	$root_dir = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
	$path = $root_dir."/library/Smarty/";
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include('Smarty.class.php');
	restore_include_path();

	include('libs.php');
	
	// Initailize check variable 
	$has_PHPVersion_OK = false;
	$has_session = false;
	$has_gettext = false;
	$has_pcre = false;
	$has_mbstring = false;
	$has_mcrypt = false;
	$has_iconv = false;
	$has_ctype = false; 
	$has_readline = false;
	$has_dom = false;
	$has_mysql = false;
	$has_zlib = false;
	
	check_extension();



$smtpl = new Smarty;

//檢查PHP版本
assign_smtpl_check($smtpl, "PHP_version", $has_PHPVersion_OK );

//檢查php extension
assign_smtpl_check($smtpl, "dom", $has_dom );	
assign_smtpl_check($smtpl, "ctype", $has_ctype );	
assign_smtpl_check($smtpl, "mbstring", $has_mbstring);
assign_smtpl_check($smtpl, "pcre", $has_pcre);
assign_smtpl_check($smtpl, "session", $has_session);
assign_smtpl_check($smtpl, "gettext", $has_gettext);
assign_smtpl_check($smtpl, "readline", $has_readline);
assign_smtpl_check($smtpl, "iconv", $has_iconv);
assign_smtpl_check($smtpl, "zlib", $has_zlib);
assign_smtpl_check($smtpl, "mcrypt", $has_mcrypt);
assign_smtpl_check($smtpl, "mysql", $has_mysql);

//check php.ini
assign_smtpl_check($smtpl, "magic_gpc", ini_get("magic_quotes_gpc") );
assign_smtpl_check($smtpl, "register_globals", !ini_get("register_globals")  );
assign_smtpl_check($smtpl, "session_use_only_cookies", ini_get("session.use_only_cookies") );


$smtpl->assign("post_max_size","<font color=\"green\">".ini_get("post_max_size")."</font>");
$smtpl->assign("upload_max_filesize","<font color=\"green\">".ini_get("upload_max_filesize")."</font>");
$smtpl->assign("max_execution_time","<font color=\"green\">".ini_get("max_execution_time")."</font>");
$smtpl->assign("max_input_time","<font color=\"green\">".ini_get("max_execution_time")."</font>");
$smtpl->assign("rar_package",check_software(get_utility_path("rar", $PATHS)));

$netstat_path = get_utility_path("netstat", $PATHS) ; 
$smtpl->assign("Mysql_DB",check_software("$netstat_path -na | grep mysql"));

$smtpl->display("./install1.tpl");
return ;



function check_extension() {
	global $has_session, $has_PHPVersion_OK, $has_gettext, $has_pcre, $has_mbstring, $has_iconv, $has_ctype, $has_readline, $has_dom;
	global $has_mysql, $has_zlib, $has_mcrypt;
	
	if( substr(phpversion(), 0,1) == 5) {
		$has_PHPVersion_OK = true;
	}
	
	$extensions = get_loaded_extensions(); 
	
	if( in_array("session", $extensions ) ) {
		$has_session = true;
	}
	if( in_array("gettext", $extensions ) ) {
		$has_gettext = true;
	}if( in_array("pcre", $extensions ) ) {
		$has_pcre = true;
	}if( in_array("mbstring", $extensions ) ) {
		$has_mbstring = true;
	}if( in_array("iconv", $extensions ) ) {
		$has_iconv = true;
	}if( in_array("ctype", $extensions ) ) {
		$has_ctype = true;
	}if( in_array("readline", $extensions ) ) {
		$has_readline = true;
	}if( in_array("mysql", $extensions ) ) {
		$has_mysql = true;
	}
	if( in_array("zlib", $extensions ) ) {
		$has_zlib = true;
	}
	if( in_array("pcre", $extensions ) ) {
		$has_pcre = true;
	}
	if( in_array("mcrypt", $extensions ) ) {
        $has_mcrypt = true;
    }
	if( in_array("dom", $extensions ) ) {
		$has_dom = true;
    }
	
}
function assign_smtpl_check($smtpl, $smtpl_var_name, $valid_value) {
if($valid_value)
	$smtpl->assign($smtpl_var_name,"<font color=\"green\">ok.</font>");
else
	$smtpl->assign($smtpl_var_name,"<font color=\"red\">請開啟!</font>");	
}


function check_software($cmd)
{
	exec($cmd, $output);
	
	if(empty($output))
		return "<font color=\"red\">not ok!</font>";
	else
		return "<font color=\"green\">ok.</font>";
}
?>