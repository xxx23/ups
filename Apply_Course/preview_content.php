<?php
/*
DATE:   2009/08/02
AUTHOR: tkraha
*/

require_once("../config.php");	


//======================================== �ܨ���guest =======================================//

$login_id = 'guest'; 

global $DB_CONN, $HOME_PATH;
$isExist = $DB_CONN->getOne("select count(*) from `register_basic` where login_id='$login_id' and login_state='1';");

if($isExist != 1)
	loginFail(0);
$sql = "SELECT * FROM register_basic WHERE login_id = '$login_id' AND validated='1'";
$res = $DB_CONN->query($sql);
if (PEAR::isError($res))	die($res->getMessage());				
if( ($res->numRows()) == 0)//�b�����֭�ϥ�
{
	//�ɦV�^����
	loginFail(2);
}
else{

	$res->fetchInto($row, DB_FETCHMODE_ASSOC);
	$personal_id = $row[personal_id];
	$role_cd = $row[role_cd];

}	
	
//���Usession
session_start();
$_SESSION['personal_id'] = $personal_id;
$_SESSION['role_cd'] = $role_cd;
$_SESSION['template_path'] = $HOME_PATH . "themes/";
$_SESSION['template'] = "IE2";

setMenu($personal, $role_cd);

//�d�XIP
$ip = getenv ( "REMOTE_ADDR" );
if ( $ip == "" )
	$ip = $HTTP_X_FORWARDED_FOR;
if ( $ip == "" )
	$ip = $REMOTE_ADDR;		
//echo $sql;	
//--------------------------------------------------------
$_SESSION['personal_ip'] = $ip;	

//======================================== �i�J�ҵ{ =======================================//


	require_once("../config.php");	
	require_once("../session.php");
    require_once("../library/filter.php");
	require_once("../library/account.php");
    
    $_GET['begin_course_cd'] = required_param("begin_course_cd",PARAM_INT);
	$begin_course_cd = $_GET['begin_course_cd'];
    if(!isset($_SESSION['personal_id']))
        die("<h1>�v�����~</h1>");
	//���Ubegin_course_cd��SESSION
	$_SESSION['begin_course_cd'] = $begin_course_cd;
	$result = db_query("select course_cd , attribute from `begin_course` where begin_course_cd=$begin_course_cd;");
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$_SESSION['course_cd'] = $row['course_cd'];
	$_SESSION['attribute'] = $row['attribute'];
	$_SESSION['template'] = setCourseStyle();	
	
	//directly go to preview page !!!!!! 
  	header("Location: {$WEBROOT}Teaching_Material/textbook_preview.php");
	

function setCourseStyle(){
	$pid = $_SESSION['personal_id'];

	$style = db_getOne("select course_style from `personal_basic` where personal_id=$pid;");
	if(empty($style)){
		$style = get_style($pid, "course_style");
		db_query("update `personal_basic` set course_style='$style' where personal_id=$pid;");
	}
//���ަp��u���ϥ�IE2
	$style = 'IE2';
	return $style;
}


function setMenu($pid, $role){
	global $DB_CONN;
	$_SESSION['menu'] = array();
	$result = $DB_CONN->query("select menu_link from `lrtmenu_` where menu_id in (select menu_id from `menu_role` where role_cd=$role and is_used='y') and menu_level > 0 and menu_link like '%php%';");
	while($row = $result->fetchRow())
		array_push($_SESSION['menu'], $row[0]);
}

function loginFail($type){
	$remind = array(
		"�n�J���ѡA�z���b�����s�b�A�Э��s�T�{",
		"�n�J���ѡA�z���b���K�X���ŦX�A�Э��s�T�{",
		"�n�J���ѡA�z���b���|���Q�֭�ϥΡA�Ь��޲z��");

	echo "<script type=\"text/javascript\">alert('$remind[$type]')</script>";
	if($type == 0)
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\"/>";
	else
		echo "<script type=\"text/javascript\">history.back()</script>";
	exit(0);
}
	
	
	
?>	
