<?php
/***************************************************/
/*id: ftp_func.php v1.0 2007/8/2 by hushpuppy Exp. */
/*func: 支援pure-ftpd的相關程式function		   */
/***************************************************/


//(管理者新增教師時)，呼叫本函式新增ftp account, role為"teacher"表示教師, 其他字串表示其他人
function new_ftp_account($login_id, $pass, $home_dir)
{
	global $DATA_FILE_PATH, $DB_CONN, $WWW_GID;
	if($pass == '' || $login_id ==''){
		echo "<script>alert(\"您沒有輸入帳號或密碼!!\");</script>";
		return 0;
	}
	//查出教師personal_id
	if($home_dir == ''){
		$sql = "select personal_id from register_basic where role_cd = '1' and login_id = '$login_id'";
		$personal_id = $DB_CONN->getOne($sql);
		if(PEAR::isError($personal_id))  die($personal_id->userinfo);
		if(empty($personal_id)){
			echo "<script>alert(\"此帳號: '$login_id'不存在!\");</script>";
			return 0;
		}
		$home_dir = $DATA_FILE_PATH.$personal_id."/";
	}
	//判斷路徑是否存在
	if(!file_exists($home_dir)){
		echo "<script>alert(\"此路徑: '$home_dir'不存在!\");</script>";
		return 0;
	}
	$sql = "insert into users (User, Password, Uid, Gid, Dir)
		values ('$login_id', md5('$pass'), '10000', '$WWW_GID', '$home_dir')";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))	die($result->userinfo);
	else
		return 1;
}

//修改ftp帳號密碼, 需輸入舊帳密與新帳密
function modify_ftp_account($login_id, $new_pass, $new_dir)
{
	global $DB_CONN;
	$sql = "select * from users where User = '$login_id'";
	$result = $DB_CONN->query($sql);
	if(PEAR::isError($result))  die($result->userinfo);

	if($result->numRows() == 0 ){
		echo "<script>alert(\"警告! 目前系統中不存在 '$login_id' 這個使用者。\");</script>";
		return -1;
	}
	else{
		if($new_dir == '')
			$sql = "update users set Password = md5('$new_pass') where User = '$login_id'";
		else
			$sql = "update users set Password = md5('$new_pass'), Dir = '$new_dir' where User = '$login_id'";
		$result = $DB_CONN->query($sql);
		if(PEAR::isError($result))  die($result->userinfo);
		return 1;
	}
}

//刪除此ftp user的使用權
function delete_ftp_account($login_id)
{
  global $DB_CONN;
  $sql = "select * from users where User = '$login_id'";
  $result = $DB_CONN->query($sql);
  if(PEAR::isError($result))  die($result->userinfo);

  if($result->numRows() == 0 ){
    echo "<script>alert(\"警告! 目前系統中不存在 '$login_id' 這個使用者。\");</script>";
    return -1;
  }
  else{
    $sql = "delete from users where User = '$login_id'";
    $result = $DB_CONN->query($sql);
    if(PEAR::isError($result))  die($result->userinfo);
    return 1;
  }
}
?>
