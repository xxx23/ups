<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript">
function second_step(){
	document.getElementById("subject_choose").style.display = "";
}
function third_step(){
	document.getElementById("third_step").style.display = "";
}
function new_member(num){
	document.getElementById("input_id_"+num).style.display = "";
}
</script>
<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
li.tabC	{cursor:pointer;}
</style>
{/literal}
</head>
<body class="ifr" id="tabA">

<h1>未分組名單</h1>


<table class="datatable">
	<tr class="tr2">
	  <th colspan="5"><span class="imp">"{$homework_name}"</span>作業 未分組名單 (旁聽生不列入分組) </th>
  </tr>
<tr>
	<th>序號</th>
	<th>帳號</th>
	<th>學員編號</th>
	<th>姓名</th>
	<th>正修/旁聽</th>
	<!--<th>修課</th>-->
</tr>

	{foreach from = $name_list item = element name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
	<tr>
		<td>{$smarty.foreach.contentloop.iteration}</td>
		<td>{$element.login_id}</td>
		<td>{$element.personal_id}</td>
		<td>{$element.personal_name}</td>
		<td>{$element.status}</td>
		<!--<td>{$element.allow}</td>
		<td>{$element.status}</td>-->
	</tr>
	{else}
	<tr class="tr2">
		<td>{$smarty.foreach.contentloop.iteration}</td>
		<td>{$element.login_id}</td>
		<td>{$element.personal_id}</td>
		<td>{$element.personal_name}</td>
		<td>{$element.status}</td>
		<!--<td>{$element.allow}</td>
		<td>{$element.status}</td>-->
	</tr>

	{/if}
	{/foreach}
</table>
</p>
<!--<h1>寄發通知信給未分組學生</h1>
<p class="intro">
同學您好，.............
</p>-->
<p class="al-left">
<input type="button" value="寄發群組信" class="btn"/></p>

</html>
