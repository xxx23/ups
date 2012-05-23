<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>隨選視訊</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">
function check(type){
	//document.getElementById
	if(type == "file"){
		document.getElementById("file").disabled = "";
		document.getElementById("rfile").disabled = "disabled";
		document.getElementById("rfile_option").checked = "";
	}
	else{
		document.getElementById("file").disabled = "disabled";
		document.getElementById("rfile").disabled = "";
		document.getElementById("file_option").checked = "";
	}
}
</script>
{/literal}
</head>

<body>
<h1>隨選視訊</h1>
<form name="add_media" method="POST" action="./media_stream.php" enctype="multipart/form-data">
  <table class="datatable">
  <caption>請上傳影音檔案，學生即可使用影音串流教材</caption>
    <tr>
      <th width="100">上課日期：</th>
	  <td><input type="text" name="date" size="15" value="{$today}">
      （例如2001年7月8日，則輸入2001-07-08)</td>
    </tr>
       
    <tr>
      <th width="100">課程標題：</th>
	  <td><input type="text" name="subject" size="40" value="{$subject}"></b></font>
		{if $subject_emtpy_flag == true}
		<br/><span style="color:red">標題為空，請輸入標題</span>
		{/if}
	  </td>
    </tr>
    <tr>
      <th width="100">課程內容：</th>
	  <td><textarea name="content" cols="45" rows="8" size="37" value="">{$content}</textarea></b></font></td>
    </tr>
    {if $looking != true}
    <tr>
      <th width="100">上傳檔案：</th>
	  <td><input type="radio" id="file_option" checked="checked" name="file_option" value="upload" onClick="check('file');"></b>  
      <INPUT NAME="file" TYPE="FILE" id="file" SIZE="25"><br/>
      (支援檔案格式:wmv,wma,wav,mp3)
	  {if $file_name_duplicate == true} 
			<br/><span style="color:red">檔名重複，請更指定新檔名後重傳</span>
	  {/if}
	  {if $strang_name_flag == true} 
			<br/><span style="color:red">檔名有問題，請勿上傳特殊字元的檔名(ex: % " ' \ )</span>
	  {/if} 
	  </td>
    </tr>
    <tr>
      <th width="100">影像URL：</th>
	  <td><input type="radio" id="rfile_option" name="file_option" value="filelink" onClick="check('rfile');">
      <input type="text" id="rfile" disabled="disabled" name="rfile" size="40" value="{$file_name}">
      <br>
      請填入完整的影片檔路徑 
(如mms://myserver/abc.avi 或 http://www.youtube.com/abc)</td>
    {else}
    <input type="hidden" name="lookid" value="{$lookid}">
    {/if}	
    <tr><td colspan="2"><p class="al-left">
      <input type="submit" value="送出視訊" name="submit">
      <input type="reset" value="清除" name="Clear"></p></td>
    </tr>
  </table>
</form>
  <script><!--
{if $file_name != ""}
document.getElementById("file").disabled = "disabled";
document.getElementById("rfile").disabled = "";
document.getElementById("rfile").readOnly = "true";
document.getElementById("file_option").disabled = "disabled";
document.getElementById("rfile_option").checked = "disabled";
{/if}
--></script>
<p class="al-left">  
  <a href="./media_stream.php"><img src="{$tpl_path}/images/icon/return.gif" />返回檔案列表 </a>
</p>
</body>
</html>
