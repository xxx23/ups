<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>學習追蹤管理</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<center>

<a href="newSystem.php">新增系統</a>

<hr>

{if $menuNum > 0}
<table class="datatable">
<tr>
	<th>系統編號</th>
	<th>功能編號</th>
	<th>名稱</th>
	<th>使用狀況</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
{section name=counter loop=$menuList}
<tr>
	<td align="center">{$menuList[counter].system_id}</td>
	<td>{$menuList[counter].function_id}</td>
	<td>{$menuList[counter].name}</td>
	<td>{$menuList[counter].state}</td>
	<td>
		{if $menuList[counter].menu_type == "system"}
		<a href="newFunction.php?system_id={$menuList[counter].system_id}">新增子功能</a>
		{else}
		&nbsp;
		{/if}
	</td>
	<td>
		{if $menuList[counter].menu_type == "system"}
		<a href="modifySystem.php?system_id={$menuList[counter].system_id}">修改</a>
		{else}
		<a href="modifyFunction.php?system_id={$menuList[counter].system_id}&function_id={$menuList[counter].function_id}">修改</a>
		{/if}
	</td>
	<td>
		{if $menuList[counter].menu_type == "system"}
		<a href="deleteSystem.php?system_id={$menuList[counter].system_id}" onClick="return confirm('確定要刪除此系統以及所有的子功能嗎?')">刪除</a>
		{else}
		<a href="deleteFunction.php?system_id={$menuList[counter].system_id}&function_id={$menuList[counter].function_id}" onClick="return confirm('確定要刪除此功能嗎?')">刪除</a>
		{/if}
	</td>
</tr>
{/section}
</table>
{/if}

</center>

</body>
</html>
