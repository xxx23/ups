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

<div style="padding:30px; width:650px">
<div>
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
<table width="100%" class="datatable">
<tr class="tr2">
	<td width="15%">上課時間</td>
	<td>{$dtime}</td>
</tr>
<tr>
	<td>課程標題</td>
	<td>{$subject}</td>
</tr>
<tr class="tr2">
	<td>課程內容</td>
	<td>{$content}</td>
</tr>
</table>
</div>
</body>
</html>