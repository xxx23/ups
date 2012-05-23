<?php
/* author: lunsrot
 * Date: 2007/03/12
 */
session_start();

checkIdentification();
function identification_error(){
	global $WEBROOT;
	header('location:'. $WEBROOT. 'identification_error.html');
	exit(0);
}

function checkIdentification(){
  	global $WEBROOT ;
	//不判斷 std_course_intro2.php
  	if(strpos($_SERVER['REQUEST_URI'],$WEBROOT."/Course/std_course_intro2.php") != 0)
	{
		if(isset($_SESSION['personal_id']) != true || isset($_SESSION['role_cd']) != true){
			session_destroy();
			identification_error();
		}
	}
	return ;
}

/*author: lunsrot
 * Date: 2007/03/13
 */
function clearSession(){
	session_destroy();
}

/*author: lunsrot
 * data: 2007/03/28
 */
function verifyFunction($menu_link){
	$result = db_query("select role_cd from `lrtmenu_` A, `menu_role` B where A.menu_link='$menu_link' and B.menu_id=A.menu_id;");
	$role_cd = $_SESSION['role_cd'];
	while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
		if($row['role_cd'] == $role_cd)
			return ;
	}
	identification_error();
}

/*author: lunsrot
 * date: 2007/07/08
 * 依不同的PHP檔，它們會呼叫此函式，若它們呼叫時傳入的位址不存在於session中，則表示為猜網址
 */
function checkMenu($input){
	if(!in_array($input, $_SESSION['menu'])){
		session_destroy();
		identification_error();
	}
	return ;
}
//管理者,教務管理者
function checkAdminAcademic(){
	if(!isset($_SESSION['role_cd']) || ($_SESSION['role_cd'] != 0 && $_SESSION['role_cd'] != 6))
	{
		session_destroy();
	    identification_error();
	}
}

//管理者,教務管理者,助教
function checkAdminTeacherTa(){
	if(!isset($_SESSION['role_cd']) || ($_SESSION['role_cd'] != 0 && $_SESSION['role_cd'] != 1 && $_SESSION['role_cd'] != 2))
	{
		session_destroy();
	    identification_error();
	}
}

//管理者
function checkAdmin()
{
	if(!isset($_SESSION['role_cd']) || $_SESSION['role_cd'] != 0)
	{
		session_destroy();
	    identification_error();
	}
}


function assign_sudo_admin_url($tpl) {
    global $HOMEURL , $WEBROOT ;
    
    //變身回管理者功能
    if( isset($_SESSION['setuid'])) {

        $tpl->assign('sudo_admin_back_url', '<a href="'.$HOMEURL.$WEBROOT.'Learner_Profile/sudo_admin.php" target="_top">變回超人!</a>');
    }
}
?>
