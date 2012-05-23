<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>


<table border="0">
<tr>
	<td><a href="showArticleList.php?behavior={$behavior}">回文章一覽</a></td>
</tr>
<tr>
	<form name="handle" action="collectArticleToDiscussAreaSave.php" method="post">
	<table class="datatable">
	<tr>
		<th>選取 討論區</th>
		<th>討論區名稱</th>
		<th>討論區主旨</th>
	</tr>
	<!---------------------討論區列表------------------------->
	{section name=counter loop=$discussAreaList}
	<tr class="{cycle values=",tr2"}">
		<td><input type="checkbox" name="discuss_cd_{counter}" value="{$discussAreaList[counter].discuss_cd}" onBlur="selected=(selected || this.checked);"></td>
		<td>{$discussAreaList[counter].discuss_name}</td>
		<td>{$discussAreaList[counter].discuss_title}</td>
	</tr>
	{/section}
	<!-------------------------------------------------------->
	
	</table>
	
	<img src="{$imagePath}arrow_ltr.gif" border="0" width="38" height="22" alt="選擇的動作" >
	
	<input type="submit" name="submit" value="收藏" class="btn">
	<input type="hidden" name="src_discuss_cd" value="{$src_discuss_cd}">
	<input type="hidden" name="src_discuss_content_cd" value="{$src_discuss_content_cd}">
	<input type="hidden" name="discussAreaNum" value="{$discussAreaNum}">
	<input type="hidden" name="behavior" value="{$behavior}">
	</form>
</tr>
</table>




</body>
</html>
