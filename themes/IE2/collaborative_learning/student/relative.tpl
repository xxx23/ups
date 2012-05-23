<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生分組資料</title>

<script type="text/javascript" src="{$webroot}script/collaborative_learning/upload.js"></script>
<script type="text/javascript" src="{$webroot}script/default.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>

<h1>資源分享</h1>
<form action="relative.php" method="POST" name="delFile">
  <input type="hidden" name="option" value="delete"/>
  <input type="hidden" name="homework_no" value="{$homework_no}"/>
  <input type="hidden" name="group_no" value="{$group_no}"/>
  <table class="datatable">
	<tr> 
	  <th style="text-align:center; width:5%;"><input type="checkbox" onClick="clickAll('delFile', this);"/></th>
	  <th>上傳時間</th>
	  <th>分享資源</th>
	</tr>
	{foreach from=$relatives item=relative}
	<tr class="{cycle values=" ,tr2"}">
	  <th style="text-align:center;"><input type="checkbox" name="resource[]" value="{$relative.file_name}"/></th>
	  <th>{$relative.upload_time}</th>
	  <th><a href="{$webroot}library/redirect_file.php?file_name={$relative.encode_name}">{$relative.file_name}</a></th>
	</tr>
	{foreachelse}
	<tr>
	  <td colspan="3" style="text-align:center;">目前沒有任何已分享的資源</td>
	</tr>
	{/foreach}
  </table>
  <p class="al-left"><input type="submit" class="btn" value="刪除選取資源"/></p>
</form>
<form action="relative.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="option" value="upload"/>
  <input type="hidden" name="homework_no" value="{$homework_no}"/>
  <input type="hidden" name="group_no" value="{$group_no}"/>
  <table class="datatable">
	<tr>
	  <th>上傳資源</th>
	  <td><input name="resource[]" type="file" class="btn"/></td>
	</tr>
	<tr id="upload">
	  <th></th>
	  <td><input type="button" class="btn" value="增加檔案個數" onClick="addInput();"/></td>
	</tr>
  </table>
  <p class="al-left"><input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/></p>
</form>
</br>
</br></br>
</body>
</html>
