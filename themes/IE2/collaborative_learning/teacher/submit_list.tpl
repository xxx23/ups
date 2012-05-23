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
function upload(homework_no){
	id = "upload_form_"+homework_no;
	document.getElementById(id).style.display = "";
}
</script>
{/literal}
</head>

<body>

<h1>檢視作業繳交狀況</h1>
<table class="datatable">
  <tr> 
	  <th>組別</th>
	  <th>組名</th>
	  <th>組員名單</th>
	  <th>作業下載</th>
  </tr>
  {foreach from = $group_list item = element name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
  <tr>
	  <td>$smarty.foreach.contentloop.iteration</td>
	  <td>{$element.homework_name}</td>
	  <td>{$element.d_dueday}</td>
  </tr>
  {else}
  <tr class="tr2">
	  <td>{$element.homework_name}</td>
	  <td>{$element.d_dueday}</td>
	  <td>{$element.upload_time}</td>
  </tr>
  {/if}
	{foreachelse}
	
	{/foreach}
</table>
</br>
</br>
</br>
</br>
</body>
</html>
