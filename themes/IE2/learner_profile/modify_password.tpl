<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<title>觀看帳號</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script src="../script/calendar.js" type="text/javascript" ></script>
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}


{/literal}
-->
</script>
</head>

<body class="ifr">
<!-- 內容說明 -->
<p class="intro">
	功能說明：
<br />
</p>
<!--功能部分 -->
<form action="./modify_password.php?action=modify{$personal_id_tag2}" method="post">
<h1>帳號</h1>
{if $showOK == 1}
<div align="center"><strong><font color="red">修改成功</font></strong></div>
{/if}
{if $showErr == 1}
<div align="center"><strong><font color="red">修改失敗</font></strong></div>
{/if}
<input type="hidden" name="personal_id" value="{$personal_id}" />
<table class="datatable">
<tr>	
	<td>請輸入舊密碼</td>
	<td><input type="password" name="old_password" />{if $role_cd == 0}管理者不需要輸入舊密碼{/if}</td>
</tr>
<tr>	
	<td>請輸入新密碼</td>
	<td><input type="password" name="new_password" /></td>
</tr>
<tr>	
	<td>再輸入一次新密碼</td>
	<td><input type="password" name="again_password" /></td>
</tr>
<tr>	
	<td>密碼提示</td>
	<td><input type="text" name="password_hint" /></td>
</tr>
<tr>
	<td colspan="2">
	<p class="al-left">
	<input type="reset" value="清除資料" class="btn" />
	<input type="submit" value="確定密碼" class="btn" />
	<p>
	</td>
</tr>
</table>
</form>
<input type="button" value="返回" class="btn" onclick="javascript:location.href='./user_profile.php{$personal_id_tag1}'; " />
</body>
</html>
