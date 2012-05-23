<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新增教師到開課</title>
<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">

</head>

<body>
<!-- 標題 -->
<center>課程的資料</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">1. 先填好下列欄位，填好按送出。</font><br />
	<font color="#FF0000">2. 送出之後可以選擇授課教師。</font><br />
	<font color="#FF0000">注意；每一門課只有一個主要的填寫者。</font><br />
	<br />
</div>
<!--功能部分 -->
<table border="1">
<tr>
	<td>課程名稱</td><td>{$begin_course_name}</td>
</tr>
<tr>
	<td>開課單位</td><td>{$begin_unit_cd}</td>
</tr>
<tr>
	<td>對應內部課程號</td><td>{$inner_course_cd}</td>
</tr>
<tr>
	<td>開課開始日期</td><td>{$d_course_begin}</td>
</tr>
<tr>
	<td>開課結束日期</td><td>{$d_course_end}</td>
</tr>
<tr>
	<td>開課公開日期</td><td>{$d_public_day}</td>
</tr>
<tr>
	<td>選課開始日期</td><td>{$d_select_begin}</td>
</tr>
<tr>
	<td>選課結束日期</td><td>{$d_select_end}</td>
</tr>
<tr>
	<td>開課所屬的學年</td><td>{$course_year}</td>
</tr>
<tr>
	<td>開課所屬的學期</td><td>{$course_session}</td>
</tr>
</table>
<br />
<font color="#FF0000">授課教師</font>
<table border="1">
<tr>
	<td>人員編號</td><td>帳號</td><td>教師名稱</td><td>是否為主要填寫者</td>
</tr>
{foreach from=$teacher_data item=teacher}
<tr>
	<td>{$teacher.personal_id}</td><td>{$teacher.login_id}</td><td>{$teacher.personal_name}</td>
	<td>{$teacher.course_master}</td>
</tr>
{/foreach}
</table>
<br />
<div id="message" style="color:#0000FF">{$message}</div>
<div id="err_message" style="color:#FF0000;">{$err_message}</div>
<br />
<form method="post" action="add_teacher_to_course.php?action=addTeacher">
<font color="#FF0000">加入授課教師</font><br />
選擇：<br />
	<select name="teacher_cd">
	{html_options values=$teacher_ids selected=$teacher_id output=$teacher_names}
	</select><br />
是否為主要填寫者：
	{html_radios name="course_master" values=$course_master_ids checked=$course_master_id output=$course_master_names separator=" "}
	<br />
	<input type="submit" value="確定送出">
</form>
</body>
</html>
