<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生分組資料</title>

<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/prototype.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/debug.js"> </script>

<link href="{$webroot}script/prototype_window/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/spread.css" rel="stylesheet" type="text/css" />
<link href="{$webroot}script/prototype_window/themes/alert.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/alert_lite.css" rel="stylesheet" type="text/css" />
<link href="{$webroot}script/prototype_window/themes/alphacube.css" rel="stylesheet" type="text/css"/>
<link href="{$webroot}script/prototype_window/themes/debug.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script>
function submit(){
	document.getElementById("evaluate").value = "true";
}
</script>
{/literal}
</head>

<body >
<h1>評分結果</h1>
<fieldset>
<legend><span class="imp">第{$group_no}組, 組名：{$element.group_name}</span></legend>
	<br />
	{foreach from = $data_list item = student}
	<p class="intro">
		<span class="imp">{$student.personal_name}</span>被組內同學所評的平均分數為
		<span class="imp">{$student.average}</span>
	</p>
	<table class="datatable">
	<caption>{$student.personal_name}對組內的評分：</caption>
	<tr>
		<!--<th>帳號</th>-->
		<th>姓名</th>
		<th>分數</th>
	</tr>
	{foreach from=$student.array item=person}
	<tr>
		<td>{$person.name}</td>
		<td>{$person.score}</td>
	</tr>
	{/foreach}
	</table>
	<br />
	{/foreach}
</fieldset>
</body>
</html>
