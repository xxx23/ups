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

<body>
<form name="form_{$element.group_no}" method="post" action="./intra_group_score.php">
<input type="hidden" name="homework_no" value="{$homework_no}" />
<h1>學生組內互評分數介面</h1>
<p class="intro">請對本組組員進行評分(包含自己)，評分結果作為教師合作學習評分參考。</p>
<br />
<fieldset>
<legend>第{$group_no}組, 組名：{$element.group_name}</legend>
<table class="datatable">
	<tr>
		<!--<th>帳號</th>-->
		<th>姓名</th>
		<th>分數</th>
	</tr>	
	{foreach from = $data_list item = student name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
	<tr class="">
		<td>{$student.personal_name}</td>
		<td><input type="text" value="{$student.score}" name="stu_score[]" size="2" /></td>
	</tr>
	{else}
	<tr class="tr2">
		<td>{$student.personal_name}</td>
		<td><input type="text" value="{$student.score}" name="stu_score[]" size="2" /></td>
	</tr>
	{/if}
	{/foreach}
</table><input type="hidden" name="evaluate" value="" />
<p class="al-left"><input class="btn" type="submit" name="" value="確定更新分數" onclick="submit();" /></p>
</fieldset><br/><br />
</form>

</body>
</html>
