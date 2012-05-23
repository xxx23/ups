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
<body onLoad="closeWait();">
	<center><b>更改試題 (選擇題介面) </b></center>
	<a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/pre.gif"></a><br/>
	<div align="left">
	更換題型：
	<select name="type" onChange="selectTestType(this.selectedIndex);">
		{html_options values=$test_type output=$test_type_out selected=$test_type_slt}
	</select>
	<form method = 'POST' action = "create_test.php" enctype="multipart/form-data">
	<input class="btn" type = "hidden" name = "modify" value = "{$test_bankno}">
		<span class='required'>*</span>此題題目：<br><textarea class = "text" name="test_title" id="test_title" rows="3" cols="50" >{$question}</textarea><br><br>
		<span class='required'>*</span>請選擇答案選項個數：
		<select name = "test_count" id = "test_count" onChange ="ans_num(this.selectedIndex);">　
			{html_options values=$ans_num output=$ans_num_out selected=$ans_num_slt}
		</select><br>
		<span class='required'>*</span>單選或複選：
  		<select name="is_multiple">
			{html_options values=$is_multiple output=$is_multiple_out selected=$is_multiple_slt}
　		</select>&nbsp
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
		{/if}
		<br>
		<div id = "ans_list">
		{foreach from = $selection item = element name = selection_loop}
		<span class='required'>*</span>請輸入第{$smarty.foreach.selection_loop.iteration}選項：
		<input type = "text" name = "select_{$smarty.foreach.selection_loop.iteration}" id = "select_1" size = "60" value="{$element}"><br>
		{/foreach}
		<br><span class='required'>*</span>請選擇答案：
		{html_checkboxes name=check_array options=$box_name separator='&nbsp;&nbsp;&nbsp;&nbsp;' selected=$slt_array}
		<br>
		</div>
		<br>請輸入詳解(optional):<br><textarea name = "answer_desc" rows = "5" cols = "50" ></textarea><br><br>
		<input class="btn" type = "submit" name = "submit_over" value = "完成並結束編輯" OnClick = "openWait();">
		<input class="btn" type = "submit" name = "submit_next" value = "完成並編輯下一題" OnClick = "openWait();"><br><br>
　		<!--<input class="btn" type = "reset" name = "reset" value = "重新編輯">-->
		<!--<input class="btn" type = "button" name = "back" value = "取消編輯" onClick = "window.open('./test_bank_content.php','_self')"><br />-->
		<br/><br/><br/><a href="./test_bank_content.php"><img src="{$tpl_path}/images/icon/pre.gif"></a>
		<input type = "hidden" name = "test_type" value = "choosing">
		
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
	</form>
	<!--<p class="top"><a href="./test_bank.php">返回題庫選擇頁面</a></p>-->

</body>
</html>
