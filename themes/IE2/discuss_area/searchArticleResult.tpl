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
<h1>文章搜尋結果</h1>
<table class="datatable">
<caption>
	搜尋&nbsp;<strong>{if $searchType == 1}文章標題{elseif $searchType == 2}作者{else}文章內容{/if}</strong>
	&nbsp;包含&nbsp;<span class="imp">"{$keyword}"</span>
	&nbsp;的文章結果, 共有<strong> &nbsp;{$replyNum}
	&nbsp;</strong>筆資料符合
</caption>
<tr>
    <th>主題</th>
    <th>作者</th>
	<th>張貼日期</th>
    <th>所屬討論區</th>
</tr>

<!---------------------文章列表------------------------->
{section name=counter loop=$replyList}
<tr class="{cycle values=",tr2"}">
   <td><a href="ArticleList_intoArticle.php?action=searchArticle&discuss_cd={$replyList[counter].discuss_cd}&discuss_content_cd={$replyList[counter].discuss_content_cd}&reply_content_cd={$replyList[counter].reply_content_cd}">{$replyList[counter].discuss_title}</a></td>
   <td>{$replyList[counter].discuss_author}</td>
   <td>{$replyList[counter].d_reply}</td>
   <td>{$replyList[counter].discuss_name}</td>
</tr>
{/section}
<!------------------------------------------------------->

</table>
<p class="al-left"><img src="{$tpl_path}/images/icon/return.gif" /><a href="searchArticle.php">回搜尋文章</a></p>


</body>
</html>
