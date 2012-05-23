<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>匯入教材</title>
</head>

<body>
<form action="import_material.php" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="option" value="import"/>
	<select name="type">
		<option value="scorm2004">Scorm 2004</option>
	</select>
	<br/>
	<input type="file" name="material"/><br/>
	<input type="reset" value="清除資料"/><input type="submit" value="確定送出"/>
</form>
</body>

</html>
