<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css"/>
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<head>

<body>
{if $type == 1}
<h1>線上測驗</h1>
{elseif $type == 2}
<h1>線上作業</h1>
{else}
<h1>線上問卷</h1>
{/if}
<table class="datatable" style="width:100%;">
  <tbody>
<tr>
	<th width="30%" >名稱</th>
	<th colspan="2">完成比例</th>
  </tr>
{foreach from=$datas item=data}
<tr class="tr3">
	<td width="30%">{$data.name}</td>
	<td><div style="width:100%; border:1px solid #CCCCCC;"><img src="{$tpl_path}/images/indicator.jpg" style="width:{$data.percentage}%; height:8px;"/></div></td>
    <td width="15%">{$data.percentage}%</td>
</tr>
{/foreach}
</tbody></table>
</body>
</html>
