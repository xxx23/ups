<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

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

{literal}
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript">

function test(html,group_name,group_no,homework_no){
//var effect = new PopupEffect(html, {className: "popup_effect2", duration: 1, fromOpacity: 0.2, toOpacity: 0.4});
win = new Window({className: "alphacube", title: group_name, 
                      top:70, left:100, width:250, height:210, 
                      url: "http://140.123.5.151/Collaborative_Learning/student/inter_group_display.php?group_no="+group_no+"&homework_no="+homework_no, showEffectOptions: {duration:0.5}})
win.show();     
}

function submit(){
	document.getElementById("evaluate").value = "true";
}
</script>
{/literal}
</head>
<body id="tabA">

<!--<h1> 以下為<span class="imp">"xxx"</span>作業 已分組組別名單</h1>
<p class="intro">每組預設為"允許"，按下"不允許"將會刪除此一組別。</br>欲刪除單一組員，請選擇check box並按"刪除所選"。
<br/>欲新增單一組員，請按"新增組員"鈕。</p>-->
</br>
<!--<a href="./tea_group_infos.php">返回檢視合作學習頁面</a></br>-->
<form action="./inter_group_score.php" method="post" name="">
  <h1>學生組間互評分數介面</h1>
  <p class="intro">請對各組所分享的成果，分別給予評分(包含自己組別)，評分結果作為教師合作學習評分參考。</p>
  <table class="datatable">
    <tr>
      <th>組別</th>
	  <th>成果檢視</th>
	  <th>學生評分</th>
    </tr>	
    {foreach from = $group_list item = element name=contentloop}
    {if $smarty.foreach.contentloop.iteration %2 == 1}
    <tr>
      <td>第{$element.group_no}組</td>
	  <td><a href="#"><img src="{$tpl_path}/images/icon/download.gif"></a></td>
	  <td><input type="textarea" name="group_score[]" value="{$element.score}" size="2" /></td>
    </tr>
    {else}
    <tr class="tr2">
      <td>第{$element.group_no}組</td>
	  <td><a href="#"><img src="{$tpl_path}/images/icon/download.gif"></a></td>
	  <td><input type="textarea" name="group_score[]" value="{$element.score}" size="2" /></td>
    </tr>
    {/if}
    
    {foreachelse}
    目前沒有任何已分組學生。
    {/foreach}
    <tr class="tr2">
      <th>更新</th>
	  <td colspan="4"><input class="btn" type="submit" value="更新分數" onclick="submit();"/></td>
    </tr>
  </table>
  <input type="hidden" name="evaluate" value="" />
  <input type="hidden" name="homework_no" value="{$homework_no}" />
</form>
</html>
