<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名表</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>
<script>
function show_self_subject(){
	document.getElementById("self_subject_div").style.display = "";
	document.getElementById("cancel_self_subject_div").style.display = "";
	
	document.getElementById("enable_self_subject").value = "true";
	document.getElementById("subject_choose").style.display = "none";
}
function cancel_sulf_subject(){
	document.getElementById("self_subject_div").style.display = "none";
	document.getElementById("cancel_self_subject_div").style.display = "none";
	
	document.getElementById("enable_self_subject").value = "false";
	document.getElementById("subject_choose").style.display = "";
}
</script>
{/literal}
</head>

<body>
<h1>專案目前狀態</h1>
<form name="add_media" method="POST" action="./sign_up_form.php">
<input type="hidden" name="homework_no" value="{$homework_no}" />
<p class="intro">本專案為最多為<span class="imp">{$group_member}</span>人一組。<br />
</p>

<table border="1" class="datatable">
	<tr>
		<th>報名組名(optional)：</th>
	</tr>
	<tr><td><input type="text" name="group_name" size="40" value="{$group_name}"></td></tr>
</table>
<br />
{if $Groupped == 0}
<table border="1" class="datatable">	
	<tr>
	  <th><span class="imp">*</span><b>組員學號：<br></th>
	</tr>	
	
	{foreach from=$text item=element}
	<tr>
		<td>{$element}</td>
	</tr>
	{/foreach}
</table></br>
{else}
	{/if}
</br>
<div id="subject_choose" style="display:">
<table class="datatable">
	<tr>
		<th><span class="imp">*</span><b>選擇題目</th>
	</tr>
	{foreach from = $projectwork_list item = element name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
	<tr><td><input type="radio" name="project_name" value="{$element.project_no}" />{$element.project_content}
		{if $element.similar_project_number == 0}
			</br>此專案題目<span class="imp">不限制</span>選擇人數。
		{else}
			</br>(此專案題目最多允許<span class="imp">{$element.similar_project_number}</span>組報名,
			目前已經有<span class="imp">{$element.num}</span>組選擇。)
		{/if}
	{else}
	</td></tr>
	<tr class="tr2"><td><input type="radio" name="project_name" value="{$element.project_no}" />{$element.project_content}
		{if $element.similar_project_number == 0 && $element.self_appointed == 0}
			</br>(此專案題目<span class="imp">不限制</span>選擇人數。)
		{elseif $element.self_appointed == 1}
			<br />(此專案題目為您所自定。)
		{else}
			</br>(此專案題目最多允許<span class="imp">{$element.similar_project_number}</span>組報名,
			目前已經有<span class="imp">{$element.num}</span>組選擇。)
		{/if}
	{/if}
	</td></tr>
	{foreachelse}
	目前老師尚未新增專案題目。
	{/foreach}
</table>
</div>
{if $self_subject == 1}
	<br />
	<input type="button" class="btn" name="self_subject_content" value="自訂題目" onclick="show_self_subject();" />
	<br />
	<div id="self_subject_div" style="display:none">
	<input type="hidden" name="self_subject" value="" />
	請輸入自訂題目：<br />
	<textarea name="self_subject_content" value="" cols="40" rows="5" />{$self_subject_content}</textarea>
	</div>
	<div id="cancel_self_subject_div" style="display:none">
		<input class="btn" type="button" value="取消自訂題目"  onclick="cancel_sulf_subject();" />
	</div>
	<input type="hidden" id="enable_self_subject" name="enable_self_subject" value="false" />
{else}
{/if}
<br />
<p class="al-left">
		<input type="hidden" name="submit_form" value="{$Groupped}" />
		<input class="btn" type="submit" value="送出資料" /></p>
	</form>
</body>
</html>
