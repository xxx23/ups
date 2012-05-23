<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$subject}</title>
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>{$subject}</h1>

{if $is_outer_url != true }
<div style="padding:30px;">
	{if $is_vedio == true}
		<object classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">
		<param name="url" value="{$media_url}"/>
		<embed type="application/x-mplayer2" src="{$media_url}"></embed>
		</object>
	{/if}
	{if $is_image == true}
		<img src="{$media_url}"/>
	{/if}
	{if $unknown == true}
		<a href="{$media_url}">下載檔案</a>
	{/if}
</div>
{else}
	<p><a href="{$outer_url}" target="_blank">連至外部網頁({$outer_url})</a></p>
{/if}
<table class="datatable">
<caption>課程資訊</caption>
<tr class="tr2">
	<td width="15%">上課日期：</td>
	<td>{$dtime}</td>
</tr>
<tr>
	<td>課程標題：</td>
	<td>{$subject}</td>
</tr>
<tr class="tr2">
	<td>課程內容：</td>
	<td>{$content}</td>
</tr>
</table>
<p class="al-left">
	<a href="stu_media_stream.php">
		<img src="{$tpl_path}/images/icon/return.gif" />返回隨選視訊列表
	</a>
</p>
</body>
</html>
