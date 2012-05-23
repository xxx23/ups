<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript" src="{$webroot}script/default.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript">
function delete_confirm(){
	if(confirm("確定要刪除本作業所有報名組別資訊? (若包含成績與自訂題目，則一併刪除。)"))
        return true;
    else
        return false;
}
function new_group(){
	document.getElementById("submit_form").value = "true";
}
</script>
{/literal}
</head>
<body id="tabA">
<form name="auto" action="./tea_group_mgt.php" method="post">
<h1>自動分組</h1>
<p class="intro">自動以每組<span class="imp">{$group_member}</span>人的方式，將未完成分組的同學進行亂數隨機分組。
&nbsp;&nbsp;<input class="btn" type="submit" name="auto_grouping" value="自動分組" />
<br />(註：若無法依每組{$group_member}人的方式平均分配完，餘下人數自動分為一組。)</p>
<input type="hidden" name="homework_no" value="{$homework_no}" />
</form>

<form name="delete_all" action="./tea_group_mgt.php" method="post">
<h1>刪除分組</h1>
<p class="intro">刪除本作業所有分組資訊。(若存在組別成績，則ㄧ併刪除)
&nbsp;&nbsp;<input class="btn" type="submit" name="delete_all_group" value="刪除" onclick="return delete_confirm();"/></p>
<input type="hidden" name="homework_no" value="{$homework_no}" />
</form>

<h1> 手動分組</h1>

<p class="intro">請填選以下表單。</p>
<form name=add_media method="POST" action="./tea_group_mgt.php" enctype="multipart/form-data">
<table border="1" class="datatable">
	<tr>
		<th><span class="imp">*</span>"<b>請輸入學員帳號：
		(此project為<span class="imp">{$count}</span>人ㄧ組)</th>
	</tr>	
	{foreach from=$text item=element}
	<tr>
		<td>{$element}</td>
	</tr>
	{/foreach}
	<tr>
		<th><span class="imp">*</span><b>請選擇題目</th>
	<tr><td>
		{html_radios name='project_name' values=$project_no output=$project separator='</td></tr><tr><td>'}
		</td></tr>
	</tr>
</table>
</br>
<p class="intro">確定送出報名資訊。
<input type="hidden" name="submit_form" id="submit_form" value="" />
<input type="hidden" name="homework_no" id="homewrok_no" value="{$homework_no}" />
<input class="btn" type="submit" value="送出" onclick="new_group();" /></p>
</form>

<!--<a href="./tea_usage.php?homework_no={$homework_no}">返回檢視合作學習頁面</a>-->
</html>
