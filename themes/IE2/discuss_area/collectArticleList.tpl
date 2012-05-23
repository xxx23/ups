<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}



{/literal}

</head>
<body>

<table class="datatable">
<caption>個人收藏文章列表</caption>
<tr>
    <th>主題></th>
    <th>作者</th>
	<th>張貼日期></th>
	<th>所屬討論區</th>
    <th>所屬課程</th>    
	{if $isDeleteOn == 1}
	<th>刪除</th>
	{/if}
</tr>

<!---------------------文章列表------------------------->
{section name=counter loop=$replyList}
<form method="post" action="{$absoluteURL}deleteCollectArticle.php">
<input type="hidden" name="begin_course_cd" value="{$replyList[counter].begin_course_cd}">
<input type="hidden" name="discuss_cd" value="{$replyList[counter].discuss_cd}">
<input type="hidden" name="discuss_content_cd" value="{$replyList[counter].discuss_content_cd}">
<input type="hidden" name="reply_content_cd" value="{$replyList[counter].reply_content_cd}">

<tr class="{cycle values=",tr2"}">
   <td><a href="{$absoluteURL}ArticleList_intoArticle.php?begin_course_cd={$replyList[counter].begin_course_cd}&discuss_cd={$replyList[counter].discuss_cd}&discuss_content_cd={$replyList[counter].discuss_content_cd}&reply_content_cd={$replyList[counter].reply_content_cd}">{$replyList[counter].discuss_title}</a></td>
   <td>{$replyList[counter].discuss_author}</td>
   <td>{$replyList[counter].d_reply}</td>
   <td>{$replyList[counter].discuss_name}</td>
   <td>{$replyList[counter].begin_course_name}</td>
   {if $isDeleteOn == 1}
   <td><input type="submit" name="submit" onClick="return confirm('確定要取消收藏此文章嗎?')" value="刪除" class="btn"></td>
   {/if}
</tr>
</form>
{/section}
<!------------------------------------------------------->

</table>

</center>

</body>
</html>
