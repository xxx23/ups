<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理註冊帳號</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</script>
</head>

<body class="ifr">
<!-- 內容說明 -->
<p class="intro">
說明：<br />
</p>
<!--功能部分 -->
<div style="width:80%;">  <!-- 限制大小 -->

<table class="datatable">
<tr>
	<th><input type="checkbox" name="" onClick="" /></th>
	<th>帳號</th>
	<th>姓名</th>
	<th>密碼</th>
	<th>密碼提示</th>
	<th>性別</th>
	<th>生日</th>
	<th>郵遞區號</th>
	<th>現職</th>
	<th>學歷</th>
	<th>教師證號</th>
	<th>專長</th>
	<th>服務單位</th>
</tr>
{foreach from=$user item=user}
<tr class="{cycle values="tr2,"}" >
	<td><input type="checkbox" name="choose[]" /></td>
	<td>{$user.login_id}</td>
	<td>{$user.personal_name}</td>
	<td>{$user.pass}</td>
	<td>{$user.password_hint}</td>
	<td>{$user.sex}</td>
	<td>{$user.d_birthday}</td>
	<td>{$user.zone_cd}</td>
	<td>{$user.job}</td>
	<td>{$user.degree}</td>
	<td>{$user.teacher_doc}</td>
	<td>{$user.skill}</td>
	<td>{$user.organization}</td>
</tr>
{/foreach}
</table>
</div>



</body>
</html>
