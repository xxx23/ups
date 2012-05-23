<?php
/*****************************************************************************/
/* id: ftp_manage.php 2007/8/1 by hushpuppy Exp.   							 */
/* function: 管理者同步ftp帳號與登入帳號(users與register_basic這兩個table)		 */
/*****************************************************************************/

require_once("../session.php");
include "../config.php";
require_once("../library/ftp_func.php");
require_once("../library/passwd.php");
//checkMenu("/.php");

global $DATA_FILE_PATH;

$smtpl = new Smarty;

$New_id = $_POST['new_name'];
$New_pass = $_POST['new_pass'];
$New_path = $_POST['new_path'];


//同步化
if($_POST['consist_ftp'] == 'true'){
	consistent();
	echo "<script>alert(\"已同步化完成!\");</script>";
}

//查詢FTP使用者
if($_POST['query_user'] == 'true'){
  if(trim($New_id) == ''){
    echo "<script>alert(\"您沒有輸入帳號或密碼!!\");</script>";
  }
  else{
    $sql = "select count(*) from register_basic where role_cd = '1' and login_id = '$New_id'";
    $res = $DB_CONN->getOne($sql);
    
    if($res == 0){
      echo "<script>alert('{$New_id}帳號不存在!')</script>";
      assignTemplate($smtpl, "/learner_profile/ftp_manage.tpl");
      return -1;
    }
    
    $sql = "select pb.personal_name,rb.login_id , rb.personal_id 
            from register_basic rb , personal_basic pb 
	    where  rb.personal_id = pb.personal_id and  rb.role_cd = '1' and rb.login_id = '$New_id'";
    $res = $DB_CONN->query($sql);
    $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
    $user['id'] = $row['login_id'];
    $user['personal_id'] = $row['personal_id'];
    $user['personal_name'] = $row['personal_name'];	
    $smtpl->assign("action","query");
    $smtpl->assign("user",$user);      
    
    assignTemplate($smtpl, "/learner_profile/ftp_manage.tpl");
    return 1;
  }
}

//新增使用者
if($_POST['new_user'] == 'true'){
  if(new_ftp_account($New_id, $New_pass, $New_path) == 1)
     echo "<script>alert(\"已新增ftp帳戶:$New_id!\");</script>";
}

//修改使用者
if($_POST['modify_user'] == 'true'){
  if(modify_ftp_account($New_id, $New_pass, $New_path) == 1)
    echo "<script>alert(\"已修改使用者:$New_id!\");</script>";
}

//刪除使用者
if($_POST['delete_user'] == 'true'){
  if(delete_ftp_account($New_id) == 1)
    echo "<script>alert(\"已刪除使用者:$New_id!\");</script>";
}
 
$smtpl->assign("data_file_path",$DATA_FILE_PATH);
assignTemplate($smtpl, "/learner_profile/ftp_manage.tpl");

//同步化帳號密碼
function consistent()
{
	global $DB_CONN, $DATA_FILE_PATH, $WWW_GID;
	$sql = "select * from register_basic where role_cd = 1";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$login_id = $row['login_id'];
		if(check_if_exists($login_id) == 1)
			continue;
		else{
			$personal_id = $row['personal_id'];
			$pass = passwd_decrypt($row['pass']);
			$home_dir = $DATA_FILE_PATH.$personal_id."/";
			$insert_sql = "insert into users (User, Password, Uid, Gid, Dir)
				values ('$login_id', md5('$pass'), '20000', $WWW_GID , '$home_dir')";
			$insert_result = $DB_CONN->query($insert_sql);
			if(PEAR::isError($insert_result))	die($insert_result->userinfo);
			//print $insert_sql."<br>";
		}
	}
}

//檢查此login_id在users這個table中是否已存在，存在傳回1,否則傳回0
function check_if_exists($login_id)
{
	global $DB_CONN;
	$sql = "select * from users where User = '$login_id'";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	
	if($result->numRows() == 0)
		return 0;
	else
		return 1;
}
?>
