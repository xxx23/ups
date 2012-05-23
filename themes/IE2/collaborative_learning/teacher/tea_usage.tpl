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
<body >

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
		<td><a href="./modify_project_data.php?homework_no={$homework_no}&key={$key}">檢視</a></td>
		<td>{$percentage}%</td>
		{if $num == 0}
		<td>未分組</td>
		{else}
		<td>已分組</td>
		{/if}
		<td>{$due_day}</td>
	</tr>
    </table>
  <h1>合作學習使用說明</h1>
<fieldset>
  <legend>分組資訊</legend>
  <li>已分組名單
	  </li><p class="intro">教師檢視已分組名單，並可手動新增、刪除特定學生。</p>
  <li>未分組名單
	  </li><p class="intro">教師檢視未分組名單資訊。</p>
  <li>教師分組介面
	  </li><p class="intro">教師可透過自動分組功能自動幫學生分組、刪除學生組別、新增組別。</p>
    </fieldset>
<fieldset>
  <legend>參考資訊</legend>
  <li>檢視分享資訊
	  </li><p class="intro">檢視各組學生上傳的分享資訊。</p>
  <li>檢視學生時程表
	  </li><p class="intro">檢視各組學生的時程規劃。</p>
    </fieldset>
<fieldset>
  <legend>成果資訊</legend>
  <li>檢視各組成果
	  </li><p class="intro">檢視各組學生的成果發表。</p>
    </fieldset>
<fieldset>
  <legend>討論資訊</legend>
  <li>分組討論區
	  </li><p class="intro">進入各組合作學習討論區</p>
  <li>線上聊天室
	  </li><p class="intro">線上聊天室</p>
    </fieldset>
<fieldset>
  <legend>評分資訊</legend>
  <li>以個人為單位評分

  </li>
  <li>以組為單位評分

  </li><li>評分結果</li><br />
	  <p class="intro">評分結果可依個人單位與組別單位的評分結果，加權平均，顯示合作學習最後成績。</p>
    </fieldset>
<fieldset>
  <legend>題目資訊</legend>
    <li>新增專案題目
  	  </li> <p class="intro">新增本作業的專案題目。</p>
    <li>檢視與修改專案題目
  	  </li><p class="intro">檢視與修改本作業已存在的專案題目。</p>
    </fieldset>
    </br>
</body>
</html>
