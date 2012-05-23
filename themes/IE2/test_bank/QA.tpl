<HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/progress.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/test_bank/test_related.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>
</head>

<body class="ifr">
	<p class="address">目前所在位置: 學習活動 >> 測驗 >> 題庫管理 >> 題目新增　>> 問答題</p>
	<h1>[題庫管理工具]</h1>
	<fieldset>
	<legend><span class="imp">編輯問答題介面</span></legend>
	<a href="./test_bank_content.php"><img src="./images/pre.gif"></a><br/>
	<h3>更換題型：
	<select name="type" onChange="selectTestType(this.selectedIndex);">
		<option value = "0" > 請選擇題型 </option>
		<option value = "1" > 選擇題 </option>
		<option value = "2" > 是非題 </option>
		<option value = "3" > 填充題 </option>
		<option value = "4" selected> 簡答題 </option>
	</select>
	</h3>
	<p><strong>(所有含<span class='required'>*</span>的欄位為必填)</strong>    </p>
	<form method = 'POST' action = "create_test.php" enctype="multipart/form-data">
		<span class='required'>*</span>此題題目：<br><textarea name = "test_title" id="test_title" rows = "8" cols = "80" value = ""></textarea><br><br>
		此題難易度：
		<select name = "degree">
			<option value = "0" >易</option>
			<option value = "1" selected>中</option>
			<option value = "2" >難</option>
　		</select><br><br>
		上傳圖片(optional)：<input class="btn" type = "file" name = "pic_file"><br>
		上傳影音(optional)：<input class="btn" type = "file" name = "av_file"><br><br>
		請輸入詳解(optional):<br><textarea name = "answer_desc" rows = "5" cols = "50" value = ""></textarea><br><br>
		<input class="btn" type = "submit" name = "submit_over" value = "完成並結束編輯" OnClick = "openWait();">
		<input class="btn" type = "submit" name = "submit_next" value = "完成並編輯下ㄧ題" OnClick = "openWait();"><br><br>
　		<input class="btn" type = "reset" name = "reset" value = "重新編輯">
<!--<input class="btn" type = "button" name = "back" value = "取消編輯" onClick = "window.location='./test_bank_content.php';"><br />-->
		<br/><br/><br/><a href="./test_bank_content.php"><img src="./images/pre.gif"></a>
		<input type = "hidden" name = "test_type" value = "QA">
	</form>
	<!-- waiting bar-->
		<span id="please_wait" style="display:none;">
			<div style="cursor:move;" class="form" onMouseDown="init();"  >
			<center>
        	<img src="./images/preceeding.gif"></img> <br />
       	 <span class="imp">處理中請稍後...</span><br />
			</div>
			</center>
		</span>
		<!-- waiting bar-->
	</fieldset>
</body>
</html>
