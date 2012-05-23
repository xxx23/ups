<html>
<head>
	<title>隨選視訊</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../script/default.js"></script> 			
{literal}
	<script type="text/javascript">
		function delete_confirm(file_name,url_file_name){
	
			if( file_name.match(/[\\\'%"`]/) ){
				alert("檔名有奇怪字元，請從ftp刪除");
				return false;
			}
			if( confirm('真的要刪除此檔?') ) {
				window.location='./media_stream.php?ftp_del_filename='+url_file_name;
				return true;
			}
			return false;
		}
		
		function zip(element_id){
			if(document.getElementById(element_id).style.display==""){
				document.getElementById(element_id).style.display="none";
			}else{
				document.getElementById(element_id).style.display="";
			}
		}
	</script>
{/literal}	
	
</head>

<body>
{if $no_content == 1}
	<h1>沒有選擇教材，請先至教材選取，選擇新教材</h1>
{else}

<h1>隨選視訊</h1>
<p><span style="vertical-align:top"><img src="{$tpl_path}/images/icon/add.gif" /><a href="./media_stream_input.php">上傳影音檔案</a></span></p>
<!-- From used To delete file -->	
<form name="delFile" method="post" action="./media_stream.php" enctype="multipart/form-data">
<table class="datatable">
	<tr>
		<th><input type="checkbox" onClick="clickAll('delFile', this);"/>選擇刪除</th>
		<th>標題</th>
		<th>上課日期</th>
		<th>連結</th>
	</tr>
	{foreach from=$content item=element name=contentloop}
	<tr class="{cycle values=" ,tr2"}">
		<td><input type="checkbox" name="seq[]" value="{$element.seq}"></td>
		<td><a href="./media_stream_input.php?lookid={$element.seq}">{$element.subject}</a></td>
		<td>{$element.d_course}</td>
		<td>{if $$element.rfile_url !=""}
			<a href="on_line.php?seq={$element.seq}" target="_blank" >
			<img src="{$tpl_path}/images/icon/go.gif" /></a>
			{/if}
		</td>
	</tr>
	{foreachelse}	
	<tr>
		<td colspan="4" align="center">目前沒有影音檔案</td>
	</tr>
	{/foreach}
</table>
	{if $smarty.foreach.contentloop.total > 0}
	<p>
	<input type="submit" class="btn" value="刪除" name="submit">&nbsp;&nbsp;
	<input type="reset" class="btn" value="重設" name="clear"></p>
	{/if}
</form>


<br/>

<h1>FTP視訊列表</h1>
<p class="intro">
此表格為經由FTP上傳至系統的視訊，若想增加至系統請點選[新增詳細資訊]
 (PS.檔案若未加入描述資訊學生將看不到)
</p>

<table class="datatable">
<tr>
	<th colspan="3" width="35%">檔案列表</th>
</tr>
{foreach from = $list_dir item = element name = dir_contentloop }
<tr class="{cycle values=" ,tr2"}">
	<td width="40%">{$element.file_name}</td>
	<td> 
		<input class="btn" type="button" value="新增詳細資訊"
		 onclick="javascript:window.location='./media_stream_input.php?file={$element.file_name_64encode}'">
	</td>
	<td>
		<input class="btn" type="button" value="從FTP刪除此檔案" title="刪除將無法回覆"
		 onclick="delete_confirm('{$element.file_name}','{$element.file_name_64encode}')">
	</td>
</tr>
{foreachelse}
<tr>
    <td align="center">目前沒有未加入詳細資訊的檔案</td>
</tr>
{/foreach}
</table>

<br/>
<br/>


<h1  style="cursor:hand;" onclick="zip('ftp_upload_info')">FTP上傳相關資訊</h1>
<div id="ftp_upload_info">
	<fieldset><legend>FTP登入資訊</legend>
	    <ul>
			<li>FTP IP:&nbsp;<span class="imp">{$ftp_ip}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PORT:&nbsp;<span class="imp">{$ftp_port}</span>&nbsp;&nbsp;&nbsp; 帳號密碼:<span class="imp">同網頁平台</span></li>
			<li><a href="{$ftp_path}" target="_blank">{$ftp_path}</a> &nbsp;(IE7使用者請將網址貼至檔案總管)</li>
			<li>PS. 使用檔案總管上傳中文檔案，需要重新改名避免亂碼問題，或請參考下列軟體</li>
			<li>FTP帳號密碼同平台上的登入帳號密碼，本系統預設編碼為<span class="imp">utf-8</span>，請使用支援UTF-8編碼的FTP軟體連上系統FTP&nbsp;ex:&nbsp;<a href="http://filezilla-project.org/" target="_blank">FileZilla</a></li>
			<li>經由FTP新增、上傳的資料夾，在教材系統上無法顯現，若欲新增教材目錄，請透過本平台的編輯教材功能新增資料夾節點</li>
	    </ul>	
		<table class="datatable">
			<tr>
				<th>資料夾</th>
				<th>資料夾作用</th>
				<th>詳細說明</th>
				
			</tr>
			<tr>
				<td>textbook</td>
				<td>教材目錄</td>
				<td>所有教材放置的目錄，</td>
				
			</tr>	
			<tr class="tr2">
				<td>export_data</td>
				<td>匯出教材目錄</td>
				<td>匯出的資料放置的目錄</td>
			</tr>
			<tr>
				<td>test_bank</td>
				<td>題庫目錄</td>
				<td>題庫資料放置的目錄(一般不會動到)</td>
			</tr>
			<tr class="tr2">
				<td>video</td>
				<td>視訊目錄</td>
				<td>隨選視訊檔案的目錄</td>
			</tr>
		</table>
	</fieldset>
</div>
{/if}
</body>
</html>
