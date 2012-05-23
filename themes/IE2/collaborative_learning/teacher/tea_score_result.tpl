<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript">
function submit_update(){
	document.getElementById("update_submit").value = "true";
}
</script>

{/literal}
</head>
<body>

<h1>評分結果</h1>
<table class="datatable">
<tr>
	<th>序號</th>
	<th>帳號</th>
	<th>姓名</th>
	<th>分數</th>
</tr>
<form action="./tea_score_result.php" method="post">
	{foreach from = $name_list item = element name=contentloop}
	<tr class="{cycle values=" ,tr2"}">
		<td>{$smarty.foreach.contentloop.iteration}</td>
		<td>{$element.login_id}</td>
		<td>{$element.personal_name}</td>
		<td>{$element.score}</td>
	</tr>
	{/foreach}
</table>
<input type="hidden" id="update_submit" name="update_submit" value="false" />
<input type="hidden" name="homework_no" value="{$homework_no}" />
<!--<center><input class="btn" type="submit" name="update" value="更新以上成績" onclick="submit_update();" /></center>-->
</html>