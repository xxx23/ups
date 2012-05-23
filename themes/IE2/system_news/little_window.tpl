<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<title>System News</title>
</head>

<body style="background-color:E6E6E6;">
<center>
<p align="right"> <a href="../System_News/systemNews_CourseNews.php" target="information">返回課程公告</a></p>
<table class="functable" width="90%">
  <tbody>
	<tr>
		<th>等級</th>
		<th>標題</th>
	</tr>
	{foreach from=$data item=entry}
	<tr class="{cycle values=" ,tr2"}">
		<td>
	  	{if $entry.important == 0} <img src="{$tpl_path}/images/icon/low.gif"/>
      		{elseif $entry.important == 1} <img src="{$tpl_path}/images/icon/mid.gif"/>
      		{elseif $entry.important == 2} <img src="{$tpl_path}/images/icon/high.gif"/>
      		{/if}
		</td>
		<td><a href="../System_News/systemNews_show_rss.php?argument={$entry.news_cd}_" target="information">{$entry.subject}</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td style="text-align:center;" colspan="2">目前沒有任何公告</td>
	</tr>
	{/foreach}
</tbody></table></center>
</body>

</html>
