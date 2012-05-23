<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <h1>分享資訊</h1>
  {foreach from=$groups item=group}
  <table class="datatable">
	<tr>
		<th>第{$group.group_no}組</th><th>{$group.group_name}</th>
	</tr>
	{foreach from=$group.resources item=resource}
	<tr class="{cycle values=" ,tr2"}">
		<td>{$resource.upload_time}</td><td><a href="{$webroot}library/redirect_file.php?file_name={$resource.encode_name}">{$resource.file_name}</a></td>
	</tr>
	{foreachelse}
	<tr><td colspan="2">此組目前沒有任何分享資源</td></tr>
	{/foreach}
  </table>
  {foreachelse}
  <p class="intro">目前沒有任何組別</p>
  {/foreach}
</body>
</html>
