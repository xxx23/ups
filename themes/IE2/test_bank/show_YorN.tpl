<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視題目內容 (是非題)</title>
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
		正確答案為：<br><br>
		{if $row.answer == 0}
	 	   是<input type = "radio" name = "ans" value = "2" disabled>
	   	   否<input type = "radio" name = "ans" value = "1" checked disabled><br><br>
		{else}
		   是<input type = "radio" name = "ans" value = "2" checked disabled>	
		   否<input type = "radio" name = "ans" value = "1" disabled><br><br>
		{/if}
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
