<html>
<head>
<title> 發表新文章/回覆文章 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}

<SCRIPT LANGUAGE="JavaScript">

function check_post() 
{
	var error = true;
	var msg = "請輸入";
	
	if(post_article.discuss_title.value.length==0)
	{
		error = false;
		msg = msg + " 標題";
	}

	if(post_article.content_body.value.length==0)
	{
		error = false;
		msg = msg + " 內容";
	}

	if((post_article.file.value.length > 0) && (post_article.file.value.indexOf(".") == -1))
	{
		error = false;
		msg = msg + " 檔案的副檔名";
	}
	
	if(!error)	alert(msg);
	
	return error;
}

</SCRIPT>

{/literal}

</head>

<body>
<h1>討論區 - 發表文章</h1>
<form name="post_article" action="newArticleSave.php" method="post" enctype="multipart/form-data" onSubmit="return check_post();">
    
  <table class="datatable">
    <tr>
      <th>標題</th>
      <td><input type="text" name="discuss_title" value="{$discuss_title}" size="40" maxlength="160"></td>
    </tr>
    <tr>
      <th>內容</th>
      <td><textarea name="content_body" style="width:100%" rows="7">{$content_body}</textarea></td>
    </tr>
    <tr>
      <th>附加檔案</th>
      <td><input type="file" name="file"></td>
    </tr>
    <!--
<tr>
	<td bgcolor="#4d6be2"><font color=#ffffff>附加語音檔案&nbsp;(請先按右邊[</font><font color=red>錄音</font><font color=#ffffff>])</font></td>
    <td bgcolor="#cdeffc">
		<object classid="clsid:A809FC66-1FEB-11D5-A00F-00D0B74E04B7" id="AudioBoard1" width="83" height="32" codebase="http://cyberccu.ccu.edu.tw/learn/packages/audioboard.cab#version=2,0,0,2" standby="Loading AudioBoard Components" type="application/x-oleobject">
		<param name="FilePath" value="c:\_upload.gsm">
		<param name="UploadMode" value="1">
		<param name="Server" value="cyberccu.ccu.edu.tw">
		<param name="UploadFile" value ="652667861.gsm">
		<param name="SystemMode" value="100">
		<param name="SDThreshold" value="30000">
		<param name="RecordSeconds" value="15">
		<param name="SilenceCompensation" value="2">
		<param name="Codec" value="1">
		</object>
		<input type="hidden" name="sound" value="652667861.gsm">
	</td>
</tr>
-->
  </table>
<p class="datatable">    
<input type="hidden" name="behavior" value="{$behavior}">
  <input type="hidden" name="action" value="{$action}">
  <input type="hidden" name="reply_content_cd" value="{$reply_content_cd}">
  <input type="hidden" name="type" value="{$type}">
   
  {if $action=="new"}
  <input type="submit" name="submit" value="發表文章" class="btn">  
  {else}
  <input type="submit" name="submit" value="回覆文章" class="btn">  
  {/if}
    
  <input type="reset" name="reset" value="清除資料" class="btn">  
    
  {if $action=="new" && $type=='group'}
  <input type="button" value="回上一頁" onClick="location.href='groupShowArticleList.php?behavior={$behavior}'" class="btn"> 
  {elseif $action=="new"}
  <input type="button" value="回上一頁" onClick="location.href='showArticleList.php?behavior={$behavior}'" class="btn">  
  {else}
  <input type="button" value="回上一頁" onClick="location.href='ArticleList_intoArticle.php?behavior={$behavior}&reply_content_cd={$reply_content_cd}&type={$type}'" class="btn">  
  {/if}
  </p>
</form>
</body>
</html>
