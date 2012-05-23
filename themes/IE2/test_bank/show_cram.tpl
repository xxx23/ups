<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>檢視題目內容 (填充題)</title>
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
		<br><img src="{$IMG_PATH}" height="350" width="350"><br>
	{else}
	{/if}
	{if $AV == 1}
		<br><embed src="{$AV_PATH}" height="350" width="350"></embed><br>
	{else}
	{/if}
		<h4>{$row.question}&nbsp; </h4>
		<!--<embed src="./files/2.wmv" height="300" width="300" /><br>-->
		
		<br>正確答案為：<br>
		{foreach from = $answer item = num name = ans_loop}
			{$num}.<input type = "text" name = "cram_1" size = "60" value="{$ansArray.$num}" disabled><br>
		{/foreach}
		<br><br>
		<!--<input type="button" value="確定送出" disabled>
		<input type="button" value="清除" disabled>-->
	</fieldset>
	<br>
	 {if $from ==  1}
	 &nbsp;&nbsp;&nbsp;<a href="javascript:window.close();">關閉視窗</a>
	 <!--<input type="button" value="返回題庫內容" onClick="window.open('./test_bank_content.php','_self');-->
	 {else}
	  <br><a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/return.gif">返回題庫內容</a>
	 {/if}
</body>
</html>
