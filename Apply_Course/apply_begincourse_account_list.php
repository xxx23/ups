<?php 
//列出開課帳號，使用者透過此介面管理
require_once("../config.php"); 
require_once("../library/filter.php"); 
require_once("../library/Pager.class.php") ; 
require_once('lib.php');

$tpl = new Smarty ; 

//prepare data 
$list_type 	= optional_param("list_type", 0, PARAM_INT); 
$category 	= optional_param("category", '0', PARAM_TEXT); 
$page 		= optional_param("page", 1, PARAM_INT); 

$params = array(
	'list_type' =>$list_type , 
	'category' => $category , 
	'page' => $page
) ;

//default 
$sql_where = ' where ' ; 

//帳號狀態
$sql_where .= ' state=' .$list_type;
$page_title = $account_list_type_state[$list_type] . '列表'; 

//帳號身份種類
if( $category != '0' )
	$sql_where .= ' AND category="' .$category . '"' ;
	
$options_categroy['options'] = $account_categroy ; 
$options_categroy['selected'] = $category ; 


// setting pager 
$sql_total_data = 'select count(*) from register_applycourse ' . $sql_where ; 
$total_data = db_getOne($sql_total_data);
$pager = new Pager( array('page'=>$page, 'per_page'=>15, 'data_cnt'=>$total_data)) ; //每頁15筆資料

$sql_where .=  " order by account" ; 

//列出帳號 
$sql_account_data = " select * from register_applycourse " . $sql_where  . $pager->getSqlLimit();


$account_data = db_getAll($sql_account_data) ; 

$tpl->assign("default_url_param", $params ); 
$tpl->assign("default_url_param_json", json_encode($params) ); 
$tpl->assign('pageOptions', $pager->getSmartyHtmlOptions() );
$tpl->assign("page_title", $page_title);
$tpl->assign("account_data", $account_data) ; 
$tpl->assign('category', $options_categroy) ; 
$tpl->assign("list_type", $list_type) ; 
$tpl->assign("page", $page) ; 
$tpl->assign("base_url", basename($_SERVER['SCRIPT_FILENMAE']) ) ; 


assignTemplate($tpl, "/apply_course/apply_begincourse_account_list.tpl");


?>