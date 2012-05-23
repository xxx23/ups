<html>
<head>
<title>現有的討論主題</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<STYLE type=text/css>
	.popupmenu_popup {
	color: #FFFFFF;
	border: 1px solid #63B2DE;
	}
	.popupmenu_option {
	background: #DEE7F7;
	color: #000000;
	font: 12px Tahoma, Verdana;
	white-space: nowrap;
	padding:3px 8px;
	cursor: pointer;
	}
	.popupmenu_option a {
	color: #000000;
	padding:3px 8px;
	text-decoration: none;
	}
	.popupmenu_highlight {
	background: #63B2DE;
	color: #FFFFFF;
	font: 12px Tahoma, Verdana;
	white-space: nowrap;
	padding:3px 8px;
	cursor: pointer;
	}
	.popupmenu_highlight a {
	color: #FFFFFF;
	padding:3px 8px;
	text-decoration: none;
	}
	.nav {
	font: 12px Tahoma, Verdana;
	color: #000000;
	font-weight: bold;
	}
</STYLE>
<script language="Javascript">

</script>
{/literal}
<script type="text/javascript" src="{$javascriptPath}common.js"></script>
<script type="text/javascript" src="{$javascriptPath}menu.js"></script>
</head>
<body>
<h1>討論區文章列表</h1>
<div class="al-left"><a href="newArticle.php?behavior={$behavior}"><img src="{$tpl_path}/images/icon/article_new.gif" >發表新主題</a> 
</div>	
{if $articleNum > 0}
<table class="datatable">
<caption>目前為第 <span class="imp">{$currentPageNumber}</span> 頁, 共有 <span class="imp">{$totalPageNumber} </span>頁,  <span class="imp">{$articleNum}</span> 篇討論文章
</caption>
  <tr>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=2">主題</a></th>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=3">張貼者</a></th>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=4">張貼日期</a></th>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=5">最近回覆日期</a></th>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=6">點閱次數</a></th>
    <th><a href="showArticleList.php?behavior={$behavior}&sortby=7">回覆次數</a></th>
    {if $isCollectOn == 1}
    <th>收至精華區</th>
    {/if}
    <th>刪除</th>
    </tr>
  <!---------------------文章列表------------------------->
  {section name=counter loop=$articleList}
  <tr class="{cycle values=",tr2"}">
    <td>{if $articleList[counter].viewed_all != 0}<font color="red">+</font>{/if}
    <a href="ArticleList_intoArticle.php?behavior={$behavior}&discuss_content_cd={$articleList[counter].discuss_content_cd}">{$articleList[counter].discuss_title}</a></td>
    <td>{$articleList[counter].discuss_author}</td>
    <td>{$articleList[counter].d_created}</td>
    <td><span id="replylist{$articleList[counter].discuss_content_cd}"> {$articleList[counter].d_replied}
      <script type="text/javascript">menuregister(false, "replylist{$articleList[counter].discuss_content_cd}", true)</script>
      </span> </td>
    <td>{$articleList[counter].viewed}</td>
    <td>{$articleList[counter].reply_count}</td>
    {if $isCollectOn == 1}
    <td>
	<a href="collectArticleToDiscussArea.php?behavior={$behavior}&discuss_content_cd={$articleList[counter].discuss_content_cd}"><img src="{$tpl_path}/images/icon/article_good.gif" alt="收至精華區"></a>
	  </td>
    {/if}
    {if $isDeleteOn == 1}
    <td>
	<a href="deleteArticle.php?behavior={$behavior}&discuss_content_cd={$articleList[counter].discuss_content_cd}" onClick="return confirm('確定要刪除此文章嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a>
    </td>
    {elseif $personal_id == $articleList[counter].author_id}
    <td>
    	<a href="deleteArticle.php?behavior={$behavior}&discuss_content_cd={$articleList[counter].discuss_content_cd}" onClick="return confirm('確定要刪除此文章嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a>
    </td>
    {else}
    	<td>
	</td>
    {/if} </tr>
  {/section}
  <!------------------------------------------------------->
</table>
<p align="center">
  &nbsp;
  {if $currentPageNumber > 1} <a href="showArticleList.php?behavior={$behavior}&currentPageNumber={$currentPageNumber-1}&sortby={$sortby}"><img src="{$tpl_path}/images/icon/pre.gif" alt="上一頁"></a> {/if}
  &nbsp;
  {section name=counter loop=$pageLinkList}
  {if $currentPageNumber == $pageLinkList[counter]} <span class="imp">{$pageLinkList[counter]}</span>&nbsp;  
  {else} <a href="showArticleList.php?behavior={$behavior}&currentPageNumber={$pageLinkList[counter]}&sortby={$sortby}">{$pageLinkList[counter]} </a>&nbsp;  
  {/if}
  {/section}
  &nbsp;
  {if $currentPageNumber < $totalPageNumber} <a href="showArticleList.php?behavior={$behavior}&currentPageNumber={$currentPageNumber+1}&sortby={$sortby}"><img src="{$tpl_path}/images/icon/next.gif" alt="下一頁"></a> {/if}</p>
{/if}
<!---------------------訊息框列表------------------------->
{section name=articleListCounter loop=$articleList}
<div class="popupmenu_popup" id="replylist{$articleList[articleListCounter].discuss_content_cd}_menu" style="display: none">
  <table cellpadding="4" cellspacing="0" border="0">
    {section name=replyListDataCounter loop=$replyList[articleListCounter]}
    <tr>
      <td class="popupmenu_option"><a href="ArticleList_intoArticle.php?behavior={$behavior}&discuss_content_cd={$articleList[articleListCounter].discuss_content_cd}&reply_content_cd={$replyList[articleListCounter][replyListDataCounter].reply_content_cd}" class="nav">{$replyList[articleListCounter][replyListDataCounter].discuss_title} | {$replyList[articleListCounter][replyListDataCounter].reply_person} | {$replyList[articleListCounter][replyListDataCounter].d_reply}</a> </td>
    </tr>
    {/section}
  </table>
</div>
{/section}
<!----------------------------------------------------->
{if $showArticleListTemplateNumber == 1}
<p class="al-left">
	<a href="showArticleList.php?behavior={$behavior}&showArticleListTemplateNumber=2"><img src="{$tpl_path}/images/icon/change.gif" alt="切換樣式">切換樣式</a>
</p>
{else if $showArticleListTemplateNumber == 2}
<p class="al-left">
	<a href="showArticleList.php?behavior={$behavior}&showArticleListTemplateNumber=1"><img src="{$tpl_path}/images/icon/change.gif" alt="切換樣式">切換樣式</a>
</p>
{/if} 

<p class="al-left">
	{if $isBackOn == 1} 
	<a href="showDiscussAreaList.php?behavior={$behavior}">	<img src="{$tpl_path}/images/icon/return.gif" width="24" height="26">返回討論區列表 </a>
	<br />
	{/if}
	{if $showRss == 1}
	<a  title="Link to the RSS 2.0 feed." href="{$absoluteURL}{$rssPage}"><img src="{$imagePath}rss20_logo.gif" style="border:0px;" alt="RSS 2.0" /></a> 
	{/if}
</p>

</body>
</html>
