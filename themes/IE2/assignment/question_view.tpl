<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>檢視作業題目</title>
{if $math == 1}
<script type="text/javascript" src="{$webroot}script/ASCIIMathML.js"></script>
<script type="text/javascript" src="{$webroot}script/ASCIIMathMLdisplay.js"></script>
{/if}
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>檢視作業題目</h1>
<fieldset>
<legend>作業名稱：{$name}</legend>
{if $math == 1}
<div>
	<textarea name="content" cols="80" rows="7" style="scroll: auto;" id="inputText" readonly>{$question}</textarea>
	<div id="outputNode"/>
	<script type="text/javascript"><!--
	math_display();
	--></script>
</div>
{else}
<div> {$question} </div>
{/if}
</fieldset>
<fieldset>
<legend>相關檔案</legend>
<table class="form">
  {foreach from=$file_data item=file}
  <tr>
    <td><a href="{$webroot}library/redirect_file.php?file_name={$file.path}">{$file.name}</a></td>
  </tr>
  {/foreach}
</table>
</fieldset>
{if $math == 1}
<a href="{$webroot}MathML/MathTable.html" target="_blank">不會用數學式嗎？請點我</a><br/>
{elseif $role == 1}
<a href="tea_assignment.php?view=true&option=view&homework_no={$homework_no}&math=1">數學方程式編輯器</a>
{else}
<a href="stu_assignment.php?view=true&option=view_quest&homework_no={$homework_no}&math=1">數學方程式編輯器</a>
{/if}

{if $role == 1}
<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>
{else}
<p class="al-left"><a href="stu_assign_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>
{/if}
</body>
</html>
