<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新增教師</title>
</head>
<body>
<form method="post" action="./new_teacher.php?action=new">
<table>
<tr>
	<td colspan="2">新增教師</td>
</td>
<tr>
	<td>帳號</td>
	<td><input type="text" name="teacher_name" value="{$valueOfTeacher_name}"></td>
</tr>
<tr>
	<td>密碼</td>
	<td><input type="text" name="password" value="{$valueOfPasseord}"></td>
</tr>
</table>
<input type="submit" value="確定">
<input type="reset" value="重設">
</form>
</body>
</html>
