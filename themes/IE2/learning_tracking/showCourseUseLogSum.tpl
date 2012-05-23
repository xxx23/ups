<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>課程使用總記錄</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<legend><h1>課程使用總記錄</h1></legend>

<center>

<table class="datatable">
<tr>
	<th>課程登入總次數:</th>
	<th>課程使用總時數:</th>
	<th>討論區發表文章總次數:</th>
	<th>瀏覽教材總次數:</th>
	<th>瀏覽教材總時數:</th>
</tr>
<tr>
	<td>{$LoginCourse}</td>
	<td>{$LoginCourseTime}</td>
	<td>{$DisscussAreaPost}</td>
	<td>{$ReadText}</td>
	<td>{$ReadTextTime}</td>
</tr>
</table>

<iframe src="{$TeachingMaterial}" frameborder="no" style="width:100%; height:1000px;">
</center>

</body>
</html>
