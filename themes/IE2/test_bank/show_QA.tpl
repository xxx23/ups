<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題目內容 (簡答題)</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body class="ifr">
	<fieldset>
		<legend class="txtFormLegend"> [教師檢視題目內容] </legend>
		題目：<font color="#666666">(難易度：{$degree}) </font>
	{if $IMG == 1}
	                <br><img src="{$IMG_PATH}"><br>
	{else}
	{/if}
	{if $AV == 1}
		<br><embed src="{$AV_PATH}"></embed><br>
	{else}
	{/if}
		<h4>{$row.question}&nbsp; </h4>
		參考答案為：<br>
		<textarea name = "answer_desc" rows = "5" cols = "50" value="" disabled>{$row.answer_desc}</textarea><br><br>
		<!--<input type="button" value="確定送出" disabled>
		<input type="button" value="清除" disabled>-->
	</fieldset>
	{if $from != 1}
	<a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/return.gif">返回題庫內容</a>
	{else}
	&nbsp;&nbsp;&nbsp;<a href="javascript:window.close();">關閉視窗</a>
	{/if}
	
	<!--<input type="button" value="返回題庫內容" onClick="window.location='./test_bank_content.php';">-->
</body>
</html>
