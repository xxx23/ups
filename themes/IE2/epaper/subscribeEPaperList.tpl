<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>電子報訂閱列表</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>個人訂閱電子報列表</h1>
<table class="datatable">
<tr>
	<th>編號</th>
	<th>課程</th>
{if $isDeleteOn == 1}
	<th>刪除</th>
{/if}
</tr>

<!---------------------電子報列表------------------------->
{section name=counter loop=$epaperList}
<tr class="{cycle values=",tr2"}">
	<td>{$epaperList[counter].counter}</td>
	<td>{$epaperList[counter].begin_course_name}</a></td>
{if $isDeleteOn == 1}
	<form method="post" action="deleteSubscribeEPaper.php">	
	<td>
		<input type="hidden" name="begin_course_cd" value="{$epaperList[counter].begin_course_cd}">
		<input type="submit" name="submit" onclick="return confirm('確定要取消訂閱此電子報嗎?')" value="刪除" class="btn">
	</td>
	</form>
{/if}
</tr>
{/section}
<!-------------------------------------------------------->

</table>


</body>
</html>
