<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<head>

<body style="text-align:center;">
<h1>選擇樣板</h1>
{if $done == 1}<p><span class="imp">己完成修改，請重新整理頁面</span></p>
<script>parent.location.reload();</script>
{/if}
<table class="datatable"><tbody>
	<tr>
		<th>縮圖</th>
		<th>樣版名稱</th>
	</tr>
	{foreach from=$themes item=e}
	<tr>
		<td><img src="{$webroot}images/themes/personal/{$e.img}" style="width:320px; height:240px;"/></td>
		<td><a href="changeTemplate.php?style={$e.code}&option=change">{$e.code}</a></td>
	</tr>
	{/foreach}
</tbody></table>
</body>
</html>
