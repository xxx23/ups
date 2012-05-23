<html>
<head>
	<title>隨選視訊</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../script/default.js"></script> 			
</head>
<body class="ifr">

<h1>隨選視訊</h1>

<table class="datatable">
<tr>
	<th>標題</th>
	<th>上課日期</th>
	<th>連結</th>
</tr>
{foreach from=$content item=element name=contentloop}
<tr class="{cycle values=", tr2"}">
	<td>{if $element.is_outer_url == 1}
		<a href="./stu_media_stream_detail.php?seq={$element.seq}"><strong>{$element.subject}</strong></a>
		{else}	
		<a href="./stu_media_stream_detail.php?seq={$element.seq}&op=detail"><strong>{$element.subject}</strong></a>
		{/if}
	</td>
	<td>{$element.d_course}</td>
	<td>
		{if $$element.rfile_url !=""}
		<a href="./stu_media_stream_detail.php?seq={$element.seq}" target="_blank">
		<img src="{$tpl_path}/images/icon/go.gif" />
		</a>
		{/if}
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="3">目前沒有檔案</td>
</tr>
{/foreach}
</table>


</body>
</html>