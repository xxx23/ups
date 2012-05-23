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

</script>
<script type="text/javascript" src="{$tpl_path}/script/test_bank/test_related.js"></script>
</head>
<body class="ifr" onLoad="closeWait();">
	<p class="address">目前所在位置: 學習活動 >> 測驗 >>  題庫管理 >> 題目新增　>> 選擇題</p>
	<h1>[題庫管理工具]</h1>
	<fieldset>
	<legend>&nbsp; <span class="imp">編輯選擇題介面</span></legend>
	<a href="./test_bank_content.php"><img src="./images/pre.gif"></a><br/>

	<h3>更換題型：
	<select name="type" onChange="selectTestType(this.selectedIndex);">
		<option value = "0" > 請選擇題型 </option>
		<option value = "1" selected> 選擇題 </option>
		<option value = "2" > 是非題 </option>
		<option value = "3" > 填充題 </option>
		<option value = "4" > 簡答題 </option>
	</select>
	</h3>
<p><strong>(所有含<span class='required'>*</span>的欄位為必填)</strong>    </p>
	<form method = 'POST' action = "create_test.php" enctype="multipart/form-data">
		<span class='required'>*</span>此題題目：<br><textarea class = "text" name="test_title" id="test_title" rows="6" cols="70" value = ""></textarea></br></br>
		請選擇答案選項個數：
		<select name = "test_count" id = "test_count" onChange ="ans_num(this.selectedIndex);">　
			<option value="0" >3個選項</option>
			<option value="1" selected>4個選項</option>
            <option value="2" >5個選項</option>
			<option value="3" >6個選項</option>
		</select><br>
		<span class='required'>*</span>單選或複選：
  		<select name="is_multiple">
			<option value = "0" >單選</option>
			<option value = "1" >複選</option>
　		</select>&nbsp
		此題難易度：
		<select name = "degree">
			<option value = "0" >易</option>
			<option value = "1" selected>中</option>
			<option value = "2" >難</option>
　		</select><br><br>
		上傳圖片(optional)：<input class="btn" type = "file" name = "pic_file"><br>
		上傳影音(optional)：<input class="btn" type = "file" name = "av_file"><br><br>
		<div id = "ans_list">
		<span class='required'>*</span>請輸入第一選項：<input type = "text" name = "select_1" id = "select_1" size = "60" value=""><br>
		<span class='required'>*</span>請輸入第二選項：<input type = "text" name = "select_2" id = "select_2" size = "60" value=""><br>
		<span class='required'>*</span>請輸入第三選項：<input type = "text" name = "select_3" id = "select_3" size = "60" value=""><br>
		<span class='required'>*</span>請輸入第四選項：<input type = "text" name = "select_4" id = "select_4" size = "60" value=""><br><br>
		<span class='required'>*</span>請選擇答案：<input type = "checkbox" name = "check_array[]" id = "check_1" value = "1">1&nbsp;&nbsp;&nbsp;&nbsp;
		   	      <input type = "checkbox" name = "check_array[]" id = "check_2" value = "2">2&nbsp;&nbsp;&nbsp;&nbsp;
	   	          <input type = "checkbox" name = "check_array[]" id = "check_3" value = "3">3&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type = "checkbox" name = "check_array[]" id = "check_4" value = "4">4&nbsp;&nbsp;&nbsp;&nbsp;<br>
		</div>
		<br>請輸入詳解(optional):<br><textarea name = "answer_desc" rows = "8" cols = "50" ></textarea><br><br>
		<input class="btn" type = "submit" name = "submit_over" value = "完成並結束編輯" OnClick = "">
		<input class="btn" type = "submit" name = "submit_next" value = "完成並編輯下ㄧ題" OnClick = ""><br><br>
　		<input class="btn" type = "reset" name = "reset" value = "重新編輯">
<!--<input class="btn" type = "button" name = "back" value = "取消編輯" onClick = "window.open('./test_bank_content.php','_self')"><br />-->
		
<input type = "hidden" name = "test_type" value = "choosing">
<br/><br/><br/><a href="./test_bank_content.php"><img src="./images/pre.gif"></a>
<!-- waiting bar-->
<span id="please_wait" style="display:none;">
  <div style="cursor:move;" class="form" onMouseDown="init();"  >
    <center>
      <!--<img src="/images/ajax-loader1.gif"></img> <br />-->
      <img src="./images/proceeding.gif"></img> <br />
      <span class="imp">處理中請稍後...</span><br />
    </div>
  </center>
</span>
<!-- waiting bar-->

	</form>
	<!--<p class="top"><a href="./test_bank.php">返回題庫選擇頁面</a></p>-->
	</fieldset>

</body>
</html>
