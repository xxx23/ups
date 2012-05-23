<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<title></title>
</head>

<body>

<legend><h1>個人使用記錄</h1></legend>
<div class="describe">請注意! 當課程滿足通過條件後，系統會於每日自動判斷及傳送資料至高師大，通常需1~2個工作天，請耐心等待。 </div>
<center>

<table class="datatable">
<tr>
	<th>姓名:</th>
	<th>{$name}</th>
</tr>
<tr>
	<td>課程登入次數:</td>
	<td>{$LoginCourse}</td>
</tr>
<tr class="tr2">
	<td>課程使用時數:</td>
	<td>{$LoginCourseTime}</td>
</tr>
<tr>
	<td>課程最後登入時間:</td>
	<td>{$LastLoginCourseTime}</td>
</tr>
<tr class="tr2">
	<td>討論區發表文章次數:</td>
	<td>{$DisscussAreaPost}</td>
</tr>
<tr>
	<td>瀏覽教材次數:</td>
	<td>{$ReadText}</td>
</tr>
<tr class="tr2">
	<td>瀏覽教材總時數:</td>
	<td>{$ReadTextTime}</td>
</tr>
</table>

<iframe src="{$TeachingMaterial}" frameborder="no" style="width:100%; height:1000px;">

</center>


</body>
</html>
