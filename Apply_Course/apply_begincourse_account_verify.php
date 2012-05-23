<?php 
ini_set('dispaly_errors',1);
error_reporting(E_ALL);
global $DB_DEBUG;
$DB_DEBUG=true;
//列出開課帳號相關資訊 等系統管理者
require_once('../config.php'); 
//include('../session.php') ; 
require_once('../library/filter.php'); 
require_once('lib.php'); 
require_once($HOME_PATH . 'library/smarty_init.php');
//require_once('session.php');
//check_access('account_list');
//申請通過給予的角色權限
$menu_role_array= array('begin_course_list','begin_course','begin_course_passed_list','ws_user_index','ws_user_service_summary');



//$tpl = new Smarty ; 

$no = required_param("no", PARAM_INT); 
$state_reason = optional_param("state_reason", '', PARAM_TEXT) ; 


//轉跳頁 用的資料 可回到送過來的頁面 prepare data 
$list_type 	= optional_param("list_type", 0, PARAM_INT); 
$category 	= optional_param("category", 0, PARAM_INT); 
$page 		= optional_param("page", 1, PARAM_INT); 

//取得帳號所屬類別並給正確的查詢權限
$category_r=db_getOne("SELECT category FROM register_applycourse WHERE no=$no");
if($category_r==1){
    $menu_role_array[]='stat_request_city';
}
elseif($category_r==2){
    $menu_role_array[]='stat_request_university';
}
elseif($category_r==3)
{
    $menu_role_array[]='stat_request_doc';
}
elseif($category_r==5)
{
    $menu_role_array[]='stat_request_school';
}

$params = array(
	'list_type' =>$list_type , 
	'category' => $category , 
	'page' => $page
) ;

$menu_role = json_encode($menu_role_array); 
//處理審核
if( isset($_POST['pass'])) {
	//通過
	if($_POST['pass'] == 'true') {
		$sql= "update register_applycourse set state=1 , menu_role='$menu_role' where no=".$no ; 
		db_query($sql); 
		well_print($sql);
	}
	//不通過
	if($_POST['pass'] == 'false') {
		$sql= "update register_applycourse set state=-1, state_reason='$state_reason' where no=".$no ; 
		db_query($sql); 
	}
	
	//回到 帳號列表頁
	header("Location:apply_begincourse_account_list.php?".gen_url_param($params)) ;
	return ;
}


//default 列出所有資料待審核


$sql_account_data = " select * from register_applycourse where no=$no";
$account_data = db_getRow($sql_account_data) ; 

$account_data['category'] = $account_categroy[$account_data['category']];

$tpl->assign("page_title", $page_title);
$tpl->assign("list_type", $list_type) ; 
$tpl->assign("account_data", $account_data) ; 
$tpl->assign("list_type_base_url", $_SERVER['SCRIPT_FILENMAE']) ; 

assignTemplate($tpl, "/apply_course/apply_begincourse_account_verify.tpl");
?>
