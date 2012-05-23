<HTML>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/progress.js"></script>
<script type="text/javascript" src="test_related.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>
</head>
<body class="ifr">
	<p class="address">目前所在位置: 學習活動 >> 測驗 >> 測驗題庫 >> 題目新增 >> 是非題</p>
	<h1>[題庫管理工具]</h1>
	<fieldset>
	<legend><span class="imp">編輯是非題介面</span></legend>
	<a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/pre.gif"></a>
	更換題型：
	<select name="type" onChange="selectTestType(this.selectedIndex);">
		{html_options values=$test_type output=$test_type_out selected=$test_type_slt}
	</select>
	<!--<p class="top"><a href="./test_bank.php">返回題庫選擇頁面</a></p>-->
	</h3>
	<p><strong>(所有含<span class='required'>*</span>的欄位為必填)</strong>    </p>
	<form method = 'POST' action = "create_test.php" enctype="multipart/form-data">
		<input type="hidden" name="modify" value="{$test_bankno}" />
		<span class='required'>*</span>此題題目：<br><textarea name = "test_title" id="test_title" rows = "8" cols = "80" value = "">{$question}</textarea><br><br>
		此題難易度：
		<select name = "degree">
			{html_options values=$degree output=$degree_out selected=$degree_slt}
　		</select><br><br>
		{if $img == 1}
			上傳圖片(optional)：
			<input class="btn" type = "file" name = "pic_file" value="{$pic_file}" disabled="disabled">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<font color="#003366">已上傳的圖片：</font><a href="./redirect_file.php?file_name={$img_name}">
			<img src="{$tpl_path}/images/icon/attached.gif">{$img_name}</a> 
			<input class="btn" type="submit" name="del_img" value="刪除" value="img" onClick=""><br>
		{else}
			上傳圖片(optional)：
			<input class="btn" type = "file" name = "pic_file" value="{$pic_file}">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<font color="#003366">已上傳的圖片：無</font><br>
		{/if}
		
		{if $av == 1}
			上傳影音(optional)：
			<input class="btn" type = "file" name = "av_file" value="{$av_file}" disabled="disabled">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<font color="#003366">已上傳的影音：</font>
			<a href="./redirect_file.php?file_name={$av_name}">
			<img src="{$tpl_path}/images/icon/attached.gif">{$av_name}</a> 
			<input class="btn" type="submit" name="del_av" value="刪除" onClick="" value="av"><br>
		{else}
			上傳影音(optional)：
			<input class="btn" type = "file" name = "av_file" value="{$av_file}">
			&nbsp;&nbsp;&nbsp;&nbsp;<font color="#003366">已上傳的影音：無</font><br>
		{/if}<br><br>
		
		<span class='required'>*</span>
		請選擇答案：
		{if $answer == 0}
			否<input type = "radio" name = "ans" value = "0" checked="checked">
			是<input type = "radio" name = "ans" value = "1"><br><br>
		{else}
			否<input type = "radio" name = "ans" value = "0">
			是<input type = "radio" name = "ans" value = "1" checked="checked"><br><br>
		{/if}
		請輸入詳解(optional):<br><textarea name = "answer_desc" rows = "5" cols = "50" value = "">{$answer_desc}</textarea><br><br>
		<input class="btn" type = "submit" name = "submit_over" value = "完成並結束編輯" OnClick = "">
		<input class="btn" type = "submit" name = "submit_next" value = "完成並編輯下ㄧ題" OnClick = ""><br><br>
　		<!--<input class="btn" type = "reset" name = "reset" value = "重新編輯">-->
		<!--<input class="btn" type = "button" name = "back" value = "取消編輯" onClick = "window.location='./test_bank_content.php';"><br />-->
		<input type="hidden" name="modify" value="{$test_bankno}" />
		<br/><br/><br/><a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/pre.gif"></a>
		<input type = "hidden" name = "test_type" value = "YorN">
	</form><br><br>
	<!-- waiting bar-->
		<span id="please_wait" style="display:none;">
			<div style="cursor:move;" class="form" onMouseDown="init();"  >
			<center>
        	<!--<img src="/images/ajax-loader1.gif"></img> <br />-->
		<img src="{$tpl_path}/images/icon/proceeding.gif"></img> <br />
       	 <span class="imp">處理中請稍後...</span><br />
			</div>
			</center>
		</span>
		<!-- waiting bar-->
	<!--<p class="top"><a href="./test_bank.php">返回題庫選擇頁面</a></p>-->
	</legend>
</body>
</html>
