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
	document.getElementById("group_no").value = "{$group_no}";
}
</script>
{/literal}
</head>

<body>
<h1>學生指定任務分配界面</h1>
<form name="form_{$element.group_no}" method="post" action="./stu_task.php">
<input type="hidden" name="homework_no" value="{$homework_no}" />
<fieldset>
<legend>第{$group_no}組, 組名：{$element.group_name}</legend>
<table class="datatable">
	<tr>
		<!--<th>帳號</th>-->
		<th>姓名</th>
		<th>工作分配</th>
	</tr>	
	{foreach from = $data_list item = student name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
	<tr class="">
		<td>{$student.personal_name}</td>
		<td><input type="text" name="stu_id[]" value="{$student.assign_work}" /></td>
	</tr>
	{else}
	<tr class="tr2">
		<td>{$student.personal_name}</td>
		<td><input type="text" name="stu_id[]" value="{$student.assign_work}" /></td>
	</tr>
	{/if}
	{/foreach}
	
</table>
</fieldset><br/><br />
<p class="al-left">
<input type="hidden" name="group_no" id="group_no" value="" />
<input class="btn" type="submit" name="" value="確定送出" onclick="submit();" /></p>
</form>
</body>
</html>
