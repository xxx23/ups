<?php
/*author: lunsrot
 * date: 2007/03/13
 */
require_once('../config.php');
require_once('../session.php');
require_once($HOME_PATH.'library/filter.php');

global $DB_CONN;
require_once($HOME_PATH . 'library/smarty_init.php');


$pid = $_SESSION['personal_id'];
$role_cd = $_SESSION['role_cd'];
//$dist_cd = $_SESSION['dist_cd'];


$aim_url = optional_param('aim', '../System_News/systemNews_RoleNews.php');

//7/29 lulu - start
//2011/08/01 修改為一個query就好
$sql = "SELECT dist_cd, personal_name, photo, idorpas, 
    email, identify_id, passport FROM personal_basic WHERE personal_id = $pid";
$row = db_getRow($sql);

if($row['dist_cd']==4){
	$row['dist_cd'] = 3 ;
}
$tpl->assign('dist_cd', $row['dist_cd']);
//7/29 lulu - end

//$tmp = $DB_CONN->getOne("select personal_style from `personal_basic` where personal_id=$pid;");
//if(!empty($tmp))
//	$_SESSION['template'] = $tmp;
//都使用IE2樣板
	$_SESSION['template'] = "IE2";
$template = $_SESSION['template_path'] . $_SESSION['template'];

$tpl->assign('name', $row['personal_name']);
$tpl->assign('role_cd', $role_cd);
$tpl->assign('role_name', $DB_CONN->getOne("select role_name from `lrtrole_` where role_cd=$role_cd;"));


if($row['photo'] != "")
  $tpl->assign("havePhoto", 1);
else
  $tpl->assign("havePhoto", 0);
//if(substr($user['photo'],0,1) == "/")
//    $row['photo'] = substr($row['photo'],1,strlen($row['photo'])-1);
$row['photo'] = 'Personal_File/' . getPersonalLevel($pid) . '/' . $pid . '/' . $row['photo'];

//檢查學員是否已經填寫個人資料
if(strcmp($row['email'],"") == 0)
    $basic_info = 0;
else
    $basic_info = 1;
$check_id = ($row['idorpas']== 0)?$row['identify_id']:$row['passport'];
$basic_info_id = strcmp($check_id,"")==0?0:1;
//role_list的身份不需去檢查
$role_list = ARRAY(0,2,4,5,6);
if(in_array($_SESSION['role_cd'],$role_list))
    $basic_info = 1;


assign_sudo_admin_url($tpl) ; 

$tpl->assign( "UPS_ONLY", $UPS_ONLY);
$tpl->assign( "basic_info", $basic_info);
$tpl->assign( "basic_info_id", $basic_info_id);
$tpl->assign( "photo", $row['photo']);
$tpl->assign("webroot",$WEBROOT);
$tpl->assign('aim_url', $aim_url);
$tpl->assign("lang", $_SESSION['lang']) ;
$tpl->assign('footer_path', $HOME_PATH.'themes/IE2/footer.tpl');
assignTemplate($tpl, '/personal_page/index.tpl');
?>
