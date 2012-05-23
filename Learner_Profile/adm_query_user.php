<?php
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . 'library/account.php');
    require_once($RELEATED_PATH . 'library/filter.php');
    require_once($HOME_PATH . 'library/smarty_init.php');
	checkAdminAcademic();
	//new smarty
    //$tpl = new Smarty();
    
    $action = optional_param('action', '', PARAM_CLEAN);

	$input = $_GET;
	switch($action){	
		case "search": 
			$tpl->assign("show", 1);
			search($input);
			break;
		
		case "state": //透過hyperlink來修改
			$tpl->assign("show", 1);
            state($input);
            returnSearchPage();
			break;
		
		case "validated"://透過hyperlink來修來
			$tpl->assign("show", 1); 
			validate($input);
			returnSearchPage();
			break;
		
		case "modify"://透過botton來修改
			$tpl->assign("show", 1);
			modify($_POST);
			returnSearchPage();
			break;
		default: 
			break;
		
	}	
	$sql = "SELECT * FROM lrtrole_ ";
	$res = db_query($sql);
	while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		$role['ids'][] = $row['role_cd'];
		$role['names'][] = $row['role_name'];
	}	
	$tpl->assign("role_ids", $role[ids]);
	$tpl->assign("role_id", $role[ids][0]);
	$tpl->assign("role_names",$role[names]);	
	
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/adm_query_user.tpl");
		
//----------------function area ------------------
function search($input)
{

	global  $tpl;	

	//設定一頁顯示的筆數
	$pagesize = 15;

	//頁數設定
	if(isset($_GET['page']))
	  $page = intval($_GET['page']);	
	else
	  $page = 1;
	
	//計算記錄偏移量
    $offset = $pagesize * ($page - 1);

    // Get search value
    $search = optional_param('search', NULL, PARAM_TEXT);
    $role = optional_param('role', NULL, PARAM_INT);
    $login_id = optional_param('login_id', NULL, PARAM_TEXT);
    $personal_name = optional_param('personal_name', NULL, PARAM_TEXT);
    $state = optional_param('state', NULL, PARAM_INT);
    $validate = optional_param('validate', NULL, PARAM_INT);

    // After "modify", need to redirect page with 'GET'
    if(isset($_GET['type']) || isset($_GET['opt']))
    {
        $search = optional_param('type', NULL, PARAM_TEXT);
        $opt = optional_param('opt', NULL, PARAM_TEXT);
        switch($search)
        {
        case 'role':
            $role = $opt;
            break;
        case 'login_id':
            $login_id = $opt;
            break;
        case 'personal_name':
            $personal_name = $opt;
            break;
        case 'state':
            $state = $opt;
            break;
        case 'validate':
            $validate = $opt;
            break;

        }
    }
	
    switch($search)
    {
    case 'all':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd limit $offset,$pagesize";
        break;
    case 'role':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging  FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and o.role_cd='".$role."' limit $offset,$pagesize";
        $opt = $role;
        break;
    case 'login_id':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and r.login_id like '%".$login_id."%' limit $offset,$pagesize";
        $opt = $login_id;
        break;
    case 'personal_name':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and p.personal_name like '%".$personal_name."%' limit $offset,$pagesize";
        $opt = $personal_name;
        break;
    case 'state':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and r.login_state='".$state."' limit $offset,$pagesize";
        $opt = $state;
        break;
    case 'validate':
        $sql = "SELECT o.role_name, r.personal_id, r.role_cd, r.login_id, p.personal_name, r.login_state, r.validated, r.d_loging FROM register_basic r, personal_basic p, lrtrole_ o
            WHERE r.personal_id=p.personal_id and r.role_cd=o.role_cd and r.validated='".$validate."' limit $offset,$pagesize";
        $opt = $validate;
        break;	
    }


	//除去limit
	$tok = explode("limit",$sql);
	//echo $sql."<br>";
	$res = db_query($tok[0]);
	//查詢結果筆數
	$numrows = $res->numRows();
	
	//計算總頁數
	$pages = intval($numrows/$pagesize);
	if($numrows%$pagesize) $pages++;


	$res = db_query($sql);
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
		if($row['login_state'] == NULL)$row['login_state'] = 0;
		if($row['validated'] == NULL)$row['validated'] = 0;
		$row['state']	=  getLoginState($row['login_state']);
		$row['vali']	=  getValidated($row['validated']);
		$tpl->append("user", $row);
	}
	
	//limit the range of prepage and nextpage
	$prepage  = $page - 1;
	$nextpage = $page + 1; 
	
	//避免超出範圍
	if($prepage == 0)
	  $prepage = 1;
	if($nextpage > $pages)
	  $nextpage =  $pages;

	$tpl->assign("type", $search);
	$tpl->assign("opt", $opt);

	$pageinfo = "<a href={$_SERVER['PHP_SELF']}?action=search&type={$search}&opt={$opt}&page={$prepage}>上一頁</a>/<a href={$_SERVER['PHP_SELF']}?action=search&type={$search}&opt={$opt}&page={$nextpage}>下一頁</a>";

	//查詢出來的筆數
	$tpl->assign("numrows",$numrows);//總共查詢結果的資料數
	$tpl->assign("page",$page); //目前所在頁數
	$tpl->assign("pages",$pages);//總共的頁數
	$tpl->assign("pageinfo",$pageinfo);//換頁html


}

function state($input)
{
    if($input[state]==0)
    {
        $state = 1;
        $state_cap = "使用";
    }
    else
    {
        $state = 0;
        $state_cap = "不使用";
    }
    $sql = "select login_id from register_basic where login_id = '{$input[login_id]}'";
    $login_id = db_getOne($sql);

    $sql = "UPDATE register_basic SET login_state='".$state."' WHERE login_id='".$input[login_id]."'";
    $res = db_query($sql);
    if (PEAR::isError($res)){}
    else 
        echo "<script>alert(\"更新{$login_id}帳號使用狀況為{$state_cap}成功!\")</script>";
}
	
function validate($input)
{

    if($input[vali]==0)
    {
        $vali = 1;
        $validate_cap = "核准"; 
    }
    else
    {
        $vali = 0;
        $validate_cap = "不核准";	  
    }
    $sql = "select login_id from register_basic where login_id = '{$input[login_id]}'";
    $login_id = db_getOne($sql);
    $sql = "SELECT d_loging FROM register_basic WHERE login_id = '{$input[login_id]}'";
    $d_loging = db_getOne($sql);
    if(empty($d_loging))
    {
        $sql = "UPDATE register_basic SET validated='".$vali."' , d_loging = NOW() WHERE login_id='".$input[login_id]."'";
        $res = db_query($sql);
    }
    else
    {
        $sql = "UPDATE register_basic SET validated='".$vali."' WHERE login_id='".$input[login_id]."'";
        $res = db_query($sql);
    }
    if (PEAR::isError($res)){}
    else  
        echo "<script>alert(\"更新{$login_id}帳號是否核准為{$validate_cap}成功!\")</script>";
}
	

function modify($input)
{
    $id = optional_param('id', NULL, PARAM_ALPHA);
    // Give default flag = 1, less dangerous
    $flag = optional_param('flag', 1, PARAM_INT);
    $choose = optional_param('choose', NULL, PARAM_TEXT);
    for($i=0; $i< sizeof($choose); $i++)
    {
        if($id == 'state')
        {
            $sql = "UPDATE register_basic SET login_state='". $flag."' WHERE login_id='". $choose[$i] ."'";
        }
        elseif( $id == "validate")
        {
            $sql = "SELECT d_loging FROM register_basic WHERE login_id = '". $choose[$i] ."'";
            $d_loging = db_getOne($sql);
            if(empty($d_loging))
            {
                $sql = "UPDATE register_basic SET validated='". $flag."' , d_loging = NOW() WHERE login_id='". $choose[$i] ."'";                
            }
            else
            {
                $sql = "UPDATE register_basic SET validated='". $flag."' WHERE login_id='". $choose[$i] ."'";		
            }
        }
        else if( $id == 'delete') 
        {
            remove_account_by_login_id($choose[$i]); 
            continue ; 
        }
        $res = db_query($sql);
    }
}

function getLoginState($input)
{
	
	$output = array('不使用','使用');
	return $output[$input];
}

function getValidated($input)
{
	
	$output = array('不核准','核准');
	return $output[$input];
}

/**
 * return to search page
 *
 */
function returnSearchPage()
{
    $type = required_param('type', PARAM_TEXT);
    $page = required_param('page', PARAM_INT);
    $opt = required_param('opt', PARAM_TEXT);
    header("Location: ".$_SERVER['PHP_SELF']."?action=search&type={$type}&opt={$opt}&page={$page}");
}

?>
