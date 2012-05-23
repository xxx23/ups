<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<head>

<body style="text-align:center;">
<table border="1"><tbody>
	<tr>
		<th>縮圖</th>
		<th>樣版名稱</th>
	</tr>
	{foreach from=$themes item=e}
	<tr>
		<td><img src="{$webroot}images/themes/{$e.img}" style="width:160px; height:120px;"/></td>
		<td><a href="changeTemplate.php?style={$e.code}">{$e.code}</a></td>
	</tr>
	{/foreach}
</tbody></table>
<a href="index.php">回到個人化首頁</a>
</body>
</html>
