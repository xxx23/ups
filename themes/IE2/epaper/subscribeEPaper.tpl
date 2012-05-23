<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>訂閱電子報</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

{if $isSubscribe == 0}
<h1>訂閱管理</h1>
	<p class="intro">
		<form method="POST" action="subscribeEPaperSave.php">
		<input type="hidden" name="isSubscribe" value="1">
		 目前狀態： 未訂閱電子報。 <input type="submit" value="訂閱課程電子報" class="btn">
		</form>
		{if $role_cd == 1}
		<form method="POST" action="subscribeEPaperSaveAll.php">
		<input type="submit" value="強制學生訂閱電子報" class="btn">
		</form>
		{/if}
	</p>
{else}
<h1>訂閱管理</h1>
	<p class="intro">
		<form method="POST" action="subscribeEPaperSave.php">
		<input type="hidden" name="isSubscribe" value="0">
		目前狀態： 已訂閱電子報。 <input type="submit" value="取消訂閱課程電子報" class="btn">
		</form>
		{if $role_cd == 1}
		<form method="POST" action="subscribeEPaperSaveAll.php">
		<input type="submit" value="強制學生訂閱電子報" class="btn">
		</form>
		{/if}
	</p>
{/if}

</body>
</html>
