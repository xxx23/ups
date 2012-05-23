<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題庫內容</title>
</head>
<body>
	<center>
	<form method="POST" action="">
	<table border="1">
		<tr>
			<td colspan=6 align="center"><h2>"<font color="red">{$title}</font>" 的題庫內容如下：</h2>
				共存在<font color="#FF3300">{$test_num}</font>筆題目</td>
		</tr>
		<tr>
			<td> 題號索引 </td> <td align="center"> 題型 </td> 
			<td align="center"> 題目描述 </td> <td> 修改題目 </td> <td> 檢視題目 </td> <td> 刪除此題 </td>
		</tr>
		{foreach from = $content item = element}
		<tr>
			<td align="center">{$element.num}</td>
			<td align="center">{$element.test_type_name}</td>
			<td >{$element.question|truncate:45:" ...":true}</td>
			<td align="center"><a href="./modify_test.php?test_bankno={$element.test_bankno}">進入修改</a></td>
			<td align="center"><a href="./show_test.php?test_bankno={$element.test_bankno}">檢視</a></td>
			<td align="center"><input type="button" name="del_test" value="delete"> </td>
		</tr>
		{/foreach}
	</table>
	<br>
	<input type= "button" name = "" value="返回教材題庫頁面" onClick="window.open('./test_bank.php','_top')">
	</form>
	</center>
</body>
</html>
