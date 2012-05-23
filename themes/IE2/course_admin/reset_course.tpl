<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>新增教師到開課</title>

<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css">
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
</head>

<body class="ifr">
	<h1>{$course_name}</h1>
	{if $done==1}
	<strong>已重置完成</strong>
	{/if}
	<form action="reset_course.php" method="GET">
	<input type="hidden" name="option" value="reset_course"/>
	<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}"/>
	<table class="datatable"><tbody>
		<tr>
			<td style="width:15px;"><input type="checkbox" name="type[]" value="news"/></td><td>公告</td>
			<td style="width:15px;"><input type="checkbox" name="type[]" value="schedule"/></td><td>課程安排</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="type[]" value="material"/></td><td>課程教材</td>
			<td><input type="checkbox" name="type[]" value="assignment"/></td><td>線上作業</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="type[]" value="examine"/></td><td>線上測驗</td>
			<td><input type="checkbox" name="type[]" value="discuss"/></td><td>課程討論區</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="type[]" value="trace"/></td><td>學習追蹤</td>
			<td><input type="checkbox" name="type[]" value="roll"/></td><td>點名簿</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="type[]" value="grade"/></td><td>成績資料</td>
			<td><input type="checkbox" name="type[]" value="survey"/></td><td>線上問卷</td>
		</tr>
		<tr>
			<td><input type="checkbox" name="type[]" value="student"/></td><td>學生資料</td>
			<td><input type="checkbox" name="type[]" value="assistant"/></td><td>助教資料</td>
		</tr>
	</tbody></table>
	<input type="submit" class="btn" value="確定送出"/><input type="reset" class="btn" value="清除資料"/>
	</form>
	<a href="show_all_begin_course.php">回查詢開課</a>
</body>
</html>
