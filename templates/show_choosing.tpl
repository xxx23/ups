<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題目內容 (選擇題)</title>
</head>
<body>
	<fieldset>
	<legend class="txtFormLegend"> [教師檢視題目內容] </legend>
	題目：<font color="#666666">(難易度：{$degree}) </font>
	<h4>{$row.question}&nbsp; ( {$IsMultiple} )</h4>
	test<embed src="./files/2.wmv" height="300" width="300" />
	{foreach from = $content item = element name = selection_loop}
		{$smarty.foreach.selection_loop.iteration}.&nbsp;{$element}<br>
	{/foreach}
	<br>請選擇答案：<br>
	{foreach from = $answer item = num name = ans_loop}
		{$num}.<input type = "checkbox" name = "check" id = "check">
	{/foreach}
	<br><br>
	<input type="button" value="確定送出" disabled>
	<input type="button" value="清除" disabled>
	</fieldset>
	<br>
	<input type="button" value="返回" onClick="window.open('./test_bank_content.php','_top')">
</body>
</html>