<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation step 2.</title>
<link href="../tabs.css" rel="stylesheet" type="text/css" />
<link href="../css/content.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<link href="../form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">
	function prev_step() { 	location.href = "install1.php";  	}
	function next_step() {	location.href = "install3.php"; 	}
	
	function refresh_createUser() {
		var username = document.getElementById("db_username").value;
		var password = document.getElementById("db_userpassword").value;
		var hostname = document.getElementById("db_host").value; 
		var DBname = document.getElementById("db_name").value;
		
		document.getElementById("createDB").innerHTML = "create database " + DBname + ";" ;
		document.getElementById("createUser").innerHTML = 
		"grant all privileges on " + DBname + ".* to "+ username + "@" + hostname + " identified by '" + password + "';";
	}
	
</script>
{/literal}
</head>

<body>

	<br/><br/>
	<center>
	<h1>Installation Process - step 2.</h1>
	確認以下系統變數設定值為恰當。<br/><br/>
	
	{if $nowritable == 1 }
	<h2 style="color:red; background-color:pink">請將config.php 改成可以網頁權限可寫入</h2>
	{/if}
	{if $dbconnectionfail == 1 }
	<h2 style="color:red; background-color:pink">資料庫連線有誤，請確認資料庫相關欄位正確與否</h2>
	{/if}
	
<form method="POST" action="install3.php">
	<table border="1" class="datatable" style="width:650px;">
	<caption>系統環境設定</caption>
	
<tr>
	<td style="width:200px;"><font color="RED">$SYSTEM_BEGIN_YEAR-<br>$SYSTEM_BEGIN_MONTH-<br>$SYSTEM_BEGIN_DAY</font></td>
	<td style="width:200px;">系統起始時間:</td>
	<td style="width:200px;"><font color="green">{$SYSTEM_BEGIN_YEAR}-{$SYSTEM_BEGIN_MONTH}-{$SYSTEM_BEGIN_DAY}</font></td>
</tr>
<tr>
	<td><font color="red">$HOST</font></td>
	<td>網頁伺服器IP:</td>
	<td><font color="green"><input name="host" type="text" value="{$HOST}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$HOMEURL</font></td>
	<td>網站首頁:</td>
	<td><font color="green"><input name="homeurl" type="text" value="{$HOMEURL}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$WEBROOT</font></td>
	<td>平台根目錄相對於網頁伺服器根路徑:</td>
	<td><font color="green"><input name="webroot" type="text" value="{$WEBROOT}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$HOME_PATH</font></td>
	<td>此平台網頁根目錄絕對路徑:</td>
	<td><font color="green"><input name="home_path" type="text" value="{$HOME_PATH}" size="30"></font></td>
</tr>
{*
<tr>
	<td><font color="red">$WWW_GID</font></td>
	<td>網頁群組的Group ID</td>
	<td><font color="green"><input name="www_gid" type="text" value="{$WWW_GID}" size="30"></font></td>
</tr>
*}
<input name="www_gid" type="hidden" value="{$WWW_GID}" size="30" />
<input name="css_path" type="hidden" value="{$CSS_PATH}" size="30" />
<input name="javascript_path" type="hidden" value="{$JAVASCRIPT_PATH}" size="30" />
<input name="image_path" type="hidden" value="{$IMAGE_PATH}" size="30" />
<input name="library_path" type="hidden" value="{$LIBRARY_PATH}" size="30" />
<input name="theme_path" type="hidden" value="{$THEME_PATH}" size="30" />
<input name="data_file_path" type="hidden" value="{$DATA_FILE_PATH}" size="30" />
<input name="media_file_path" type="hidden" value="{$MEDIA_FILE_PATH}" size="30" />
<input name="course_file_path" type="hidden" value="{$COURSE_FILE_PATH}" size="30" />
<input name="personal_path" type="hidden" value="{$PERSONAL_PATH}" size="30" />
<input name="scorm_path" type="hidden" value="{$SCORM_PATH}" size="30" />
<input name="share_path" type="hidden" value="{$SHARE_PATH}" size="30" />

<!-- ----------------------------------------------------- 
<tr>
	<td><font color="red">$CSS_PATH</font></td>
	<td>CSS相對路徑:</td>
	<td><font color="green"><input name="css_path" type="text" value="{$CSS_PATH}" size="30"></font></td>
</tr>

<tr>
	<td><font color="red">$JAVASCRIPT_PATH</font></td>
	<td>JavaScript相對路徑:</td>
	<td><font color="green"><input name="javascript_path" type="text" value="{$JAVASCRIPT_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$IMAGE_PATH</font></td>
	<td>image相對路徑:</td>
	<td><font color="green"><input name="image_path" type="text" value="{$IMAGE_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$LIBRARY_PATH</font></td>
	<td>library相對路徑:</td>
	<td><font color="green"><input name="library_path" type="text" value="{$LIBRARY_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$THEME_PATH</font></td>
	<td>佈景主題相對路徑:</td>
	<td><font color="green"><input name="theme_path" type="text" value="{$THEME_PATH}" size="30"></font></td>
</tr>

<tr>
	<td><font color="red">$DATA_FILE_PATH</font></td>
	<td>教師教材、測驗題庫放置路徑:</td>
	<td><font color="green"><input name="data_file_path" type="text" value="{$DATA_FILE_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$MEDIA_FILE_PATH</font></td>
	<td>課程串流影片放置路徑:</td>
	<td><font color="green"><input name="media_file_path" type="text" value="{$MEDIA_FILE_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$COURSE_FILE_PATH</font></td>
	<td>課程作業、問卷、測驗等檔案放置路徑:</td>
	<td><font color="green"><input name="course_file_path" type="text" value="{$COURSE_FILE_PATH}" size="30"></font></td>
</tr>
<tr>
	<td><font color="red">$PERSONAL_PATH</font></td>
	<td>個人檔案、筆記本系統放置路徑：</td>
	<td><font color="green"><input name="personal_path" type="text" value="{$PERSONAL_PATH}" size="30"></font></td>
</tr>
--------------------------------------------------------------------- -->
</table>
<!--  utility PATH ---------------------------------------------------- -->
<br/>
<input type="hidden" name="rar_path" value="{$RAR_PATH}" />
<input type="hidden" name="php_path" value="{$PHP_PATH}" />
{*
<table border="1" class="datatable" style="width:650px;">
<caption>Utility PATH 相關設定</caption>
<tr>
	<td style="width:200px"><font color="red">$RAR_PATH</font></td>
	<td style="width:200px">RAR 執行檔路徑</td>
	<td style="width:200px"><input name="rar_path" value="{$RAR_PATH}"></td>
</tr>
<tr>
	<td><font color="red">$PHP_PATH</font></td>
	<td>PHP 執行檔路徑</td>
	<td><input name="php_path" value="{$PHP_PATH}"></td>
</tr>
</table>

<br/>
*}
<!--  utility PATH ---------------------------------------------------- -->


<table border="1" class="datatable" style="width:650px;">
<caption>Mail 相關設定</caption>
<tr>
	<td style="width:200px"><font color="red">$MAIL_SMTP_HOST</font></td>
	<td style="width:200px">Mail SMTP HOST</td>
	<td style="width:200px"><input name="mail_smtp_host" value="{$MAIL_SMTP_HOST}"></td>
</tr>
<tr>
	<td><font color="red">$MAIL_SMTP_HOST_PORT</font></td>
	<td>Mail SMTP HOST PORT</td>
	<td><input name="mail_smtp_host_port" value="{$MAIL_SMTP_HOST_PORT}"></td>
</tr>

<tr>
	<td><font color="red">$MAIL_ADMIN_EMAIL</font></td>
	<td>平台管理者E-mail</td>
	<td><input name="mail_admin_email" value="{$MAIL_ADMIN_EMAIL}"></td>
</tr>
<tr>
	<td><font color="red">$MAIL_ADMIN_EMAIL_NICK</font></td>
	<td>平台管理者信件稱呼</td>
	<td><input name="mail_admin_email_nick" value="{$MAIL_ADMIN_EMAIL_NICK}"></td>
</tr>
<tr>
	<td colspan="3">
		如果您的系統SMTP不必認證，請不要填寫帳號密碼，如果需要使用sendmail寄信請自行修改/library/mail.php - mailto 的function
	</td>
</tr>
<tr>
	<td><font color="red">$MAIL_ADMIN_USER</font></td>
	<td>Mail SMTP 帳號</td>
	<td><input name="mail_admin_user" value="{$MAIL_ADMIN_USER}"></td>
</tr>
<tr>
	<td><font color="red">$MAIL_ADMIN_PASSWROD</font></td>
	<td>Mail SMTP 密碼</td>
	<td><input name="mail_admin_password" value="{$MAIL_ADMIN_PASSWROD}"></td>
</tr>
</table>
<br/>

<!---------------------- FTP ------------------------ -->

<table border="1" class="datatable" style="width:650px;">
<caption>FTP相關設定</caption>
<tr>
	<td style="width:200px" ><font color="red">$FTP_IP</font></td>
	<td style="width:200px" >FTP IP</td>
	<td style="width:200px" ><font color="green">{$FTP_IP}</font></td>
</tr>
<tr>
	<td><font color="red">$FTP_PORT</font></td>
	<td>FTP port</td>
	<td><font color="green">{$FTP_PORT}</font></td>
</tr>
<tr>
	<td><font color="red">$MAX_UPLOAD_SIZE</font></td>
	<td>最大上傳限制 (單位:MB)</td>
	<td><font color="green">{$MAX_UPLOAD_SIZE}</font></td>
</tr>
</table>

<!---------------------- DB ------------------------ -->

<br />

<table border="1" class="datatable" style="width:650px;">
<caption>資料庫環境設定</caption>
<tr>
	<td style="width:200px;"><font color="red">$DB_TYPE</font></td>
	<td style="width:200px;">資料庫型態</td>
	<td style="width:200px;"><font color="green">{$DB_TYPE}</font></td>
</tr>
<tr>
	<td><font color="red">$DB_HOST</font></td>
	<td>資料庫IP</td>
	<td><font color="green"><input id="db_host" name="db_host" type="text" value="{$DB_HOST}" size="30" onchange="refresh_createUser()"></font></td>
</tr>
<tr>
	<td><font color="red">$DB_NAME</font></td>
	<td>資料庫名稱</td>
	<td><font color="green"><input id="db_name" name="db_name" type="text" value="{$DB_NAME}" size="30" onchange="refresh_createUser()"></font></td>
</tr>
<tr>
	<td><font color="red">$DB_USRENAME</font></td>
	<td>資料庫使用者名稱</td>
	<td><font color="green"><input id="db_username" name="db_username" type="text" value="{$DB_USERNAME}" size="30" onchange="refresh_createUser()"></font></td>
</tr>
<tr>
	<td><font color="red">$DB_USERPASSWORD</font></td>
	<td>資料庫密碼</td>
	<td><font color="green"><input id="db_userpassword" name="db_userpassword" type="text" value="{$DB_USERPASSWORD}" size="30" onblur="refresh_createUser()"></font></td>
</tr>

</table>

<table border="1" class="datatable" style="width:650px;">
<caption>請提供系統和資料庫管理者密碼</caption>
<tr>
	<td><font color="red">$DB_ROOTPASSWORD</font></td>
	<td>資料庫root密碼</td>
	<td><font color="green"><input id="db_rootpassword" name="db_rootpassword" type="text" value="{$DB_USERPASSWORD}" size="30" onblur="refresh_createUser()"></font></td>
</tr>

</table>
{*
<table border="1" class="datatable" style="width:650px;">
<caption>想新增mysql database user 請使用下列語法</caption>
<tr>
	<td colspan="3" style="font-size:16px; color:red">
	<div>$> mysql -uroot -p</div>
	<div>mysql>
		<span id="createDB">
		create database elearning;
		</span>
	<div>mysql>
		<span id="createUser">
			grant all privileges on elearning.* to username@localhost identified by 'password';
		</span>
	</div>
	</td>
</tr>
</table>
*}
<br/>
	{if $nowritable == 1 }
	<h2 style="color:red; background-color:pink">請將config.php 改成可以網頁權限可寫入</h2>
	{/if}
	{if $dbconnectionfail == 1 }
	<h2 style="color:red; background-color:pink">資料庫連線有誤，請確認資料庫相關欄位正確與否</h2>
	{/if}
<br />
	<input type="button" value="上一步" onclick="prev_step();">
	<input type="reset"  value="清除重來">
	<input type="submit" value="下一步" > 
	<br /><br/>
</form>
	<!--<a href="install1.php">步驟1.</a>&nbsp;&nbsp;步驟2.&nbsp;&nbsp;
	<a href="install2.php">步驟3.</a>-->
	</form>
	</center>
<script type="text/javascript">
refresh_createUser();
</script>
</body>
</html>
