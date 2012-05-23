<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生合作學習首頁</title>

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
</script>
{/literal}
</head>
</br>
<body class="ifr">

  <table class="datatable">
	<caption>
	您所選擇的專案
	</caption>
	<tr> 
		<th> 作業名稱</th>
		<th>專案題目</th>
		<th>所佔比例</th>
		<th> 分組狀況</th>
		<th>  專案結束時間</th>
	</tr>
	<tr>
		<td>{$homework_name}</td>
		<td><a href="./question_view.php?homework_no={$homework_no}&key={$key}"><img src="{$tpl_path}/images/icon/view.gif" /></a></td>
		<td>{$percentage}%</td>
		{if $num == 0}
		<td>未分組</td>
		{else}
		<td>已分組</td>
		{/if}
		<td>{$due_day}</td>
	</tr>
    </table>
</br>
<h1>合作學習使用說明</h1>
<fieldset>
  <legend>分組資訊</legend>
任務分配<br />
分組報名<br />
題目與組員資料    
</fieldset>
<fieldset>
  <legend>參考資訊</legend>
時程表<br />
檢視分享資訊<br />
資源分享
</fieldset>
<fieldset>
  <legend>成果資訊</legend>
成果發表 <br />
檢視各組成果  
</fieldset>
<fieldset>
  <legend>討論資訊</legend>
分組討論區<br /> 
線上聊天室
</fieldset>
<fieldset>
  <legend>評分資訊</legend>
組內評分<br /> 
組間互評
</fieldset>
<fieldset>
  <legend>題目資訊</legend>
題目內容
</fieldset>
    </br>

</body>
</html>
