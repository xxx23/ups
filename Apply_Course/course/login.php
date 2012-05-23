<?php require_once('../Connections/courseid.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_courseid, $courseid);
$query_Recordset1 = "SELECT * FROM register_course_id";
$Recordset1 = mysql_query($query_Recordset1, $courseid) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['id'])) {
  $loginUsername=$_POST['id'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "hihi.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_courseid, $courseid);
  
  $LoginRS__query=sprintf("SELECT courseid_id, courseid_password FROM register_course_id WHERE courseid_id=%s AND courseid_password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $courseid) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<h1>開課帳號登入</h1>
<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST">
<table width="575" border="1" align="center">
  <tr>
    <td width="106" height="34">帳號</td>
    <td width="168"><input type="text" name="id" id="id" /></td>
    <td width="279" rowspan="3"><p>沒有開課帳號！</p>
      <p>若您沒有開課單位，請欲開課單位向平台申請，通過審核後即可申請開課。</p>
      <p align="right"><a href="courseid_apply.php">開課帳號申請</a></p>      
      <label></label></td>
  </tr>
  <tr>
    <td height="36">密碼</td>
    <td><input type="password" name="password" id="password" /></td>
    </tr>
  <tr>
    <td colspan="2"><label>
      <div align="center">
        <input type="submit" name="button" id="button" value="登入" />　
        <input type="reset" name="button2" id="button2" value="重填" />
        </div>
    </label></td>
    </tr>
</table>
<p>&nbsp;</p>
<div align="center"></div>
</form>
<p>&nbsp;</p>
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>
