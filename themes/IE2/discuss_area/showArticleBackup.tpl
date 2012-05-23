<html>
<head>
<title> 文章內容 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="tabs.css" rel="stylesheet" type="text/css" />
<link href="content.css" rel="stylesheet" type="text/css" />
<link href="table.css" rel="stylesheet" type="text/css" />
<link href="form.css" rel="stylesheet" type="text/css" />


{literal}

<script language="JavaScript" type="text/javascript">


</script>


{/literal}

</head>

<body>



{if $isShowMenu == 1}
<table border="0">
<tr>
	<td><a href="showArticleList.html">回[文章一覽]</a></td>
</tr>
</table>
{/if}

<table class="datatable">
<tr>
  <th rowspan="4" width="150">
	<p align="center">
		<a href="{$replyList[$currentReplyArrayNumber].personal_home}" target="_blank">{$replyList[$currentReplyArrayNumber].reply_person}</a><br>
		{$replyList[$currentReplyArrayNumber].student_name}<br>
		<img src="{$replyList[$currentReplyArrayNumber].photo}" width="60" height="65" border="0" alt=""><br>
		{$replyList[$currentReplyArrayNumber].feedback} 
	</p>
</th>
  <th width="100">主題</th>
  <td>{$replyList[$currentReplyArrayNumber].discuss_title}</td>
</tr>
<tr>
  <th>內文</th>
  <td>{$replyList[$currentReplyArrayNumber].content_body}</td>
</tr>
<tr>
  <th>相關檔案</th>
  <td><a href="{$replyList[$currentReplyArrayNumber].file_picture_name_url}">{$replyList[$currentReplyArrayNumber].file_picture_name}</a>( {$replyList[$currentReplyArrayNumber].file_picture_name_size} bytes )</td>
</tr>
<!--
<tr>
  <th>附加語音檔案</th>
  <td><object classid="clsid:A809FC66-1FEB-11D5-A00F-00D0B74E04B7" id="AudioBoard1" width="46" height="32" codebase="http://cyberccu.ccu.edu.tw/learn/packages/audioboard.cab#version=2,0,0,2" standby="Loading AudioBoard Components" type="application/x-oleobject">
	  <param name="Server" value="cyberccu.ccu.edu.tw" />
	  <param name="Url" value="discuss/attach/123965724.gsm" />
	  <param name="FilePath" value="c:\_download.gsm" />
	  <param name="SystemMode" value="101" />
	  <param name="Codec" value="1" />
	</object>          </td>
</tr>
-->
</table>


<h2>相關討論文章</h2>


<ul>
<!---------------------第一篇回覆文章------------------------->
	<li>
	{if $replyList[0].reply_content_cd == $current_reply_content_cd}
		{$replyList[0].discuss_title} | {$replyList[0].reply_person} | {$replyList[0].d_reply}<br>
	{else}
		{$replyList[0].discuss_title} | {$replyList[0].reply_person} | {$replyList[0].d_reply}<br />		
	{/if}
	</li>
<!------------------------------------------------------------>
<!---------------------回覆的文章列表------------------------->
{section name=counter loop=$replyList start=1}
	{if $replyList[counter].level == 1}		<ul><li>
	{elseif $replyList[counter].level == 2}	<ul><ul><li>
	{elseif $replyList[counter].level == 3}	<ul><ul><ul><li>
	{elseif $replyList[counter].level == 4}	<ul><ul><ul><ul><li>
	{elseif $replyList[counter].level == 5}	<ul><ul><ul><ul><ul><li>
	{elseif $replyList[counter].level == 6}	<ul><ul><ul><ul><ul><ul><li>
	{elseif $replyList[counter].level == 7}	<ul><ul><ul><ul><ul><ul><ul><li>
	{elseif $replyList[counter].level == 8}	<ul><ul><ul><ul><ul><ul><ul><ul><li>
	{elseif $replyList[counter].level == 9}	<ul><ul><ul><ul><ul><ul><ul><ul><ul><li>
	{else}									<ul><ul><ul><ul><ul><ul><ul><ul><ul><ul><li>
	{/if}
		
		{if $replyList[counter].reply_content_cd == $current_reply_content_cd}
			==>{$replyList[counter].discuss_title} | {$replyList[counter].reply_person} | {$replyList[counter].d_reply}<br>
		{else}
		{$replyList[counter].discuss_title} | {$replyList[counter].reply_person} | {$replyList[counter].d_reply}<br />
		
		<table id="reply_content_table_{$replyList[counter].reply_content_cd}" style="display:block" border="1" cellpadding="0" cellspacing="0" class="w-table">
		<tr>
			<td>
				<table class="datatable">
				<tr>
				  <th rowspan="4" width="150">
				  	<p align="center">
				  	<a href="{$replyList[counter].personal_home}" target="_blank">{$replyList[counter].reply_person}</a><br>
					{$replyList[counter].student_name}<br>
					<img src="{$replyList[counter].photo}" width="60" height="65" border="0" alt=""><br>
					{$replyList[counter].feedback} 
					</div>
					</th>
				  <th width="100">主題</th>
				  <td>{$replyList[counter].discuss_title}</td>
				</tr>
				<tr>
				  <th>內文</th>
				  <td>{$replyList[counter].content_body}</td>
				</tr>
				<tr>
				  <th>相關檔案</th>
				  <td><a href="{$replyList[counter].file_picture_name_url}">{$replyList[counter].file_picture_name}</a>( {$replyList[counter].file_picture_name_size} bytes )</td>
				</tr>
				<!--
				<tr>
					<th>附加語音檔案</th>
					<td><object classid="clsid:A809FC66-1FEB-11D5-A00F-00D0B74E04B7" id="AudioBoard1" width="46" height="32" codebase="http://cyberccu.ccu.edu.tw/learn/packages/audioboard.cab#version=2,0,0,2" standby="Loading AudioBoard Components" type="application/x-oleobject">
					  <param name="Server" value="cyberccu.ccu.edu.tw" />
					  <param name="Url" value="discuss/attach/123965724.gsm" />
					  <param name="FilePath" value="c:\_download.gsm" />
					  <param name="SystemMode" value="101" />
					  <param name="Codec" value="1" />
					</object>          
					</td>
				</tr>
				-->
				</table>
			</td>
		</tr>
		</table>
		{/if}		

	{if $replyList[counter].level == 1}		</li></ul>
	{elseif $replyList[counter].level == 2}	</li></ul></ul>
	{elseif $replyList[counter].level == 3}	</li></ul></ul></ul>
	{elseif $replyList[counter].level == 4}	</li></ul></ul></ul></ul>
	{elseif $replyList[counter].level == 5}	</li></ul></ul></ul></ul></ul>
	{elseif $replyList[counter].level == 6}	</li></ul></ul></ul></ul></ul></ul>
	{elseif $replyList[counter].level == 7}	</li></ul></ul></ul></ul></ul></ul></ul>
	{elseif $replyList[counter].level == 8}	</li></ul></ul></ul></ul></ul></ul></ul></ul>
	{elseif $replyList[counter].level == 9}	</li></ul></ul></ul></ul></ul></ul></ul></ul></ul>
	{else}									</li></ul></ul></ul></ul></ul></ul></ul></ul></ul></ul>
	{/if}
{/section}
<!------------------------------------------------------->
</ul>

</body>
</html>

