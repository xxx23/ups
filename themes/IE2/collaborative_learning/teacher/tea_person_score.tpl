<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$WEBROOT}script/prototype_window/javascripts/prototype.js"> </script>
<script type="text/javascript" src="{$WEBROOT}script/prototype_window/javascripts/effects.js"> </script>
<script type="text/javascript" src="{$WEBROOT}script/prototype_window/javascripts/window.js"> </script>
<script type="text/javascript" src="{$WEBROOT}script/prototype_window/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="{$WEBROOT}script/prototype_window/javascripts/debug.js"> </script>
<link href="{$WEBROOT}script/prototype_window/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="{$WEBROOT}script/prototype_window/themes/spread.css" rel="stylesheet" type="text/css" />
<link href="{$WEBROOT}script/prototype_window/themes/alert.css" rel="stylesheet" type="text/css"/>
<link href="{$WEBROOT}script/prototype_window/themes/alert_lite.css" rel="stylesheet" type="text/css" />
<link href="{$WEBROOT}script/prototype_window/themes/alphacube.css" rel="stylesheet" type="text/css"/>
<link href="{$WEBROOT}script/prototype_window/themes/debug.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">
function new_member(num){
	document.getElementById("input_id_"+num).style.display = "";
}

function test(html,group_name,group_no,homework_no){
//var effect = new PopupEffect(html, {className: "popup_effect2", duration: 1, fromOpacity: 0.2, toOpacity: 0.4});
top_size = group_no*250;
win = new Window({className: "alphacube", title: group_name, 
                      top:top_size, left:100, width:400, height:330, 
                      url: "./view_intra_group_score.php?group_no="+group_no+"&homework_no="+homework_no, showEffectOptions: {duration:0.5}})
win.show();     
}

function update(group_no){
	document.getElementById("update_score").value = group_no;
	document.getElementById("group_no").value = group_no;
	//alert(document.getElementById("update_score").value);
}
</script>
{/literal}
</head>
<body>
<h1>以個人為單位評分介面</h1>
</br>
{foreach from = $group_list item = element name=contentloop}
<form name="form_{$element.group_no}" method="post" action="./tea_person_score.php">
<input type="hidden" name="homework_no" value="{$element.homework_no}" />
<fieldset>
<legend><span class="imp">第{$element.group_no}組, 組名：{$element.group_name}</span></legend>
{if $element.upload == 'f'}未上傳&nbsp;&nbsp;
{else}下載本組作業：<a href="{$WEBROOT}library/redirect_file_path.php?h_no={$element.homework_no}&g_no={$element.group_no}">
		<img src="{$tpl_path}/images/icon/download.gif"></a>&nbsp;&nbsp;
{/if}
<input type="button" class="btn" value="檢視組內互評" onclick="test(this,'第{$element.group_no}組 組內互評成績',{$element.group_no},{$homework_no})" />
<table class="datatable">
	<tr>
		<th>帳號</th>
		<th>姓名</th>
		<th>分數</th>
	</tr>	
	{foreach from = $element.stu_array item = student}
	<tr class="{cycle values=",tr2"}">
		<td>{$student.login_id}</td>
		<td>{$student.personal_name}</td>
		<td><input type="text" size="2" name="stu_score_{$element.group_no}[]" value="{$student.score}" /></td>
		<input type="hidden" name="stu_id[]" value="{$student.personal_id}" />
	</tr>
	{/foreach}
	<tr><td colspan="3">
		<input type="hidden" name="group_no" id="group_no" value="{$element.group_no}"/>
	</td></tr>
	
	<tr><th colspan="4">選擇的題目</th></tr>
	<tr><td colspan="4">
	{if $element.project_content == ''}
		尚未選擇
	{else}
		{$element.project_content}
	{/if}
	</td></tr>	
</table>
<p class="al-left">
<input type="hidden" name="update_score" value="false" />
<input class="btn" type="submit" name="" value="更新成績" onclick="update({$element.group_no});" /></p>
</fieldset>
</form>
{foreachelse}
	目前沒有任何已分組學生。
{/foreach}
</html>
