<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題目內容 (是非題)</title>
</head>
<body>
	<fieldset>
	<legend class="txtFormLegend"> [教師檢視題目內容] </legend>
		題目：<font color="#666666">(難易度：{$degree}) </font>
		<h4>{$row.question}&nbsp; </h4>
		<!--<embed src="./files/2.wmv" height="300" width="300" /><br>-->
		<br>請選擇答案：<br>
		否<input type = "radio" name = "ans" value = "1">
		是<input type = "radio" name = "ans" value = "2">
		<br><br>
		<input type="button" value="確定送出" disabled>
		<input type="button" value="清除" disabled>
	</fieldset>
	<br>
	<input type="button" value="返回" onClick="window.open('./test_bank_content.php','_top')">
</body>
</html>