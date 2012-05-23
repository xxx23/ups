<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題庫列表</title>
</head>
<body>
	<center>
	
	<form method="POST" action="">
	<table border="1">
		<tr>
			<td colspan=6 align="center"><h2>"<font color="red">{$course_name}</font>" 課程共存在
			<font color="red">{$course_num}</font>筆教材如下：</h2></td>
		</tr>
		<tr>
			<td> 教材索引 </td> <td align="center"> 是否存在題庫 </td> 
			<td align="center"> 教材名稱 </td> <td> 進入編輯題庫 </td> <td> 匯出題庫 </td> <td> 刪除整份題庫 </td>
		</tr>
		{foreach from = $content item = element}
		<tr>
			<td align="center">{$element.num}</td>
			<td align="center">{$element.exist}</td>
			<td align="center">{$element.content_name}</td>
			<td align="center"><a href="./test_bank_content.php?content_cd={$element.content_cd}">編輯題庫</a></td>
			<td align="center"><input type="button" value="匯出"> </td>
			<td align="center"><input type="button" name="del_test_all" value="delete"> </td>
		</tr>
		{/foreach}
	</table>
	<br>
	</form>
	</center>
</body>
</html>