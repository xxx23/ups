<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新增教師到開課</title>
<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">
</head>

<body class="ifr" bgcolor="#E3F1FD">
<!-- 標題 -->
課程的資料
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
<table class="datatable">
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
<tr>
	<td>課程性質</td><td>{$course_classify}</td>
</tr>
<tr>
	<td>班別性質</td><td>{$coursekind}</td>
</tr>
<tr>
	<td>課程時段</td><td>{$timeSet}</td>
</tr>
<tr>
	<td>學員繳費方式</td><td>{$charge_type}</td>
</tr>
<tr>
	<td>補助單位</td><td>{$subsidizeid}</td>
</tr>
<tr>
	<td>認證表示</td><td>{$certify_type}</td>
</tr>
<tr>
	<td>召收名額</td><td>{$quantity}</td>
</tr>
<tr>
	<td>限定機關報名上課</td><td>{$locally}</td>
</tr>

<tr>
	<td>學習費用</td><td>{$charge}</td>
</tr>
<tr>
	<td>補助費用</td><td>{$subsidize_money}</td>
</tr>


</table>
<br />
<font color="#FF0000">授課教師</font>
<table class="datatable">
<tr>
	<th>人員編號</th><th>帳號</th><th>教師名稱</th><th>是否為主要填寫者</th><th>刪除</th>
</tr>
{foreach from=$teacher_data item=teacher}
<tr>
	<td>{$teacher.personal_id}</td><td>{$teacher.login_id}</td><td>{$teacher.personal_name}</td>
	<td>{$teacher.course_master}</td>
	<td><a href="./add_teacher_to_course_advance.php?action=deleteTeacher&teacher_cd={$teacher.personal_id}">刪除</a></td>
{/foreach}
</table>
<br />
<div id="message" style="color:#0000FF">{$message}</div>
<div id="err_message" style="color:#FF0000;">{$err_message}</div>
<br />
<form method="post" action="add_teacher_to_course_advance.php?action=addTeacher">
<font color="#FF0000">加入授課教師</font><br />
選擇：<br />
	<select name="teacher_cd">
	{html_options values=$teacher_ids selected=$teacher_id output=$teacher_names}
	</select><br />
是否為主要填寫者：
	{html_radios name="course_master" values=$course_master_ids checked=$course_master_id output=$course_master_names separator=" "}
	<br />
	<input class="btn" type="submit" value="確定送出">
</form>
</body>
</html>
