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
function test(html,group_name){
//var effect = new PopupEffect(html, {className: "popup_effect2", duration: 1, fromOpacity: 0.2, toOpacity: 0.4});
win = new Window({className: "alphacube", title: group_name, 
                      top:70, left:100, width:300, height:210, 
                      url: "http://140.123.5.151/Collaborative_Learning/student/group_infos.php", showEffectOptions: {duration:0.5}})
//win.show();     
win.setDestroyOnClose(); 
  win.setLocation(10, 500);
  win.show();
  win.toFront();
}
</script>
{/literal}
</head>

<body>
<h1>專案題目與組員資料</h1>
<form name="form_{$element.group_no}" method="post" action="./stu_group_infos.php">
<input type="hidden" name="homework_no" value="{$element.homework_no}" />
<fieldset>
<legend>第{$group_no}組, 組名：{$element.group_name}</legend>
<table class="datatable">
	<tr>
		<th>帳號</th>
		<th>姓名</th>
		<th>暱稱</th>
		<th>電話</th>
		<th>電子信箱</th>
	</tr>	
	{foreach from = $data_list item = student name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
	<tr class="">
		<td>{$student.login_id}</td>
		<td>{$student.personal_name}</td>
		<td>{$student.nickname}</td>
		<td>{$student.tel}</td>
		<td>{$student.email}</td>
	</tr>
	{else}
	<tr class="tr2">
		<td>{$student.login_id}</td>
		<td>{$student.personal_name}</td>
		<td>{$student.nickname}</td>
		<td>{$student.tel}</td>
		<td>{$student.email}</td>
	</tr>
	{/if}
	{/foreach}
	
	<tr><th colspan="6">選擇的題目</th></tr>
	<tr><td colspan="6">
	{if $project_content == ''}
		尚未選擇
	{else}
		{$project_content}
	{/if}
	</td></tr>	
</table>
</fieldset>
</form>
<br /><br />
</body>
</html>
