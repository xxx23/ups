<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>所有學生課程使用記錄</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<legend><h1>所有學生課程使用記錄</h1></legend>

<center>

{if $studentNum > 0}
<table class="datatable">
<tr>
	<th>姓名:</th>
	<th>課程登入次數:</th>
	<th>課程使用時數:</th>
	<th>課程最後登入時間:</th>
	<th>討論區發表文章次數:</th>
	<th>瀏覽教材次數:</th>
	<th>瀏覽教材總時數:</th>
</tr>
{section name=counter loop=$studentList}
<tr>
	<td>{$studentList[counter].name}</td>
	<td>{$studentList[counter].LoginCourse}</td>
	<td>{$studentList[counter].LoginCourseTime}</td>
	<td>{$studentList[counter].LastLoginCourseTime}</td>
	<td>{$studentList[counter].DisscussAreaPost}</td>
	<td>{$studentList[counter].ReadText}</td>
	<td>{$studentList[counter].ReadTextTime}</td>
</tr>
{/section}
</table>
{/if}

</center>

</body>
</html>
