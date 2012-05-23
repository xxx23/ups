<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation step 4.</title>
<link href="../tabs.css" rel="stylesheet" type="text/css" />
<link href="../css/content.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<link href="../form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">

function prev_step()
{
	location.href = "install4.php";
}

function next_step()
{
	location.href = "end.html";
}

function check()
{
	if(document.getElementById("admin_account").value == ""){
		alert("請輸入管理者名稱");
		return false;
	}
	if(document.getElementById("admin_pass").value == ""){
		alert("請輸入密碼");
		return false;
	}
}
</script>
{/literal}
</head>

<body><br /><br />
	<center>
	<h1>Installation Process - step 5.</h1>
	<form action="install5.php" method="post">
	
	<table border="1" class="datatable" style="width:550px;">
	<caption>初始化管理者帳號密碼</caption>
	<tr>
		<td>請輸入系統管理員帳號：</td>
		
		<td><input type="text" id="admin_account" name="admin_account" value="" /></td>
	</tr>
	<tr>
		<td>請輸入系統管理員密碼：</td>
		<td><input type="password" id="admin_pass" name="admin_pass" value="" /></td>
	</tr>
		<input type="hidden" name="admin_init" value="1" />
	</table>
	<br /><br />
	{if $created == '0'}
	<input type="submit" name="init" value="新增管理者帳戶" onclick="return check();" />
	{else}
	{$create_status}
	{/if}
	</form>
	<br /><br />
	<input type="button" value="上一步" onclick="prev_step();"> 
	<input type="button" value="下一步" onclick="next_step();"> 
	<br /><br/>
	<!--<a href="install1.php">步驟1.</a>&nbsp;&nbsp;步驟2.
	<a href="install3.php">步驟3.</a>-->
	</center>
</body>
</html>
