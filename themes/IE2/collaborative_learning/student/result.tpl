<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生分組資料</title>

<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/prototype.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="{$webroot}script/prototype_window/javascripts/debug.js"> </script>
<script type="text/javascript" src="{$webroot}script/collaborative_learning/result.js"></script>

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
<table class="datatable" style="width:95%;">
  <tr> 
	  <th>專案名稱</th>
	  <th>專案結束時間</th>
	  <th>上傳成果時間</th>
	  <th>上傳成果</th>
  </tr>
  <tr>
	  <td>{$homework_name}</td>
	  <td>{$d_dueday}</td>
	  <td>{$upload_time}</td>
	  <td><input type="button" class="btn" value="上傳成果" onclick="upload({$homework_no});" /></td>
  </tr>
</table>
<div id="upload_form_{$homework_no}" style="display:none">
<fieldset>
    <legend>合作學習成果發表</legend>
	<h1>上傳成果到<span class="imp">"{$homework_name}"</span>專案</h1>
<form method="post" enctype="multipart/form-data" action="result.php" onsubmit="return checkSubmit(this);">
	<input type="file" name="result_upload" class="btn"/>
	<input type="submit" name="submit" value="上傳檔案" class="btn" {if $upload==1}disabled{/if}/><br/>
	{if $upload==1}
	已上傳檔案：<a href="{$webroot}library/redirect_file.php?file_name={$file_path}" target="_blank">{$file_name}</a><input type="submit" class="btn" value="刪除"/>
	<input type="hidden" name="action" value="delete" />
	{else}
	<input type="hidden" name="action" value="upload" />
	{/if}
	<input type="hidden" name="homework_no" value="{$homework_no}"/>
</form>
</fieldset>
</br>
</br></br></br></br></br></br></br></br>
</body>
</html>
