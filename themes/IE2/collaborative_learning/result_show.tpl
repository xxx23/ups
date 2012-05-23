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
<h1>成果發表</h1>
	<table class="datatable">
	<tr> 
		<th>組別</th>
		<th>組名</th>
		<th>上傳成果時間</th>
		<th>成果</th>
	</tr>
	{foreach from = $project_list item = element name=contentloop}
	<tr class="{cycle values=" ,tr2"}">
		<td>{$element.group_no}</td>
		<td>{$element.group_name}</td>
		<td>{$element.upload_time}</td>
		<td><a href="{$webroot}library/redirect_file_path.php?h_no={$element.homework_no}&g_no={$element.group_no}">{$element.result_work}</a></td>
	</tr>
	{foreachelse}
	目前沒有任何合作學習作業。
	{/foreach}
</table>

</br></br></br>
</body>
</html>
