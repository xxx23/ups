<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

	<title>匯入Moodle教材</title>
</head>

<body class="ifr">
	<h1>Moodle 教材匯入</h1>
	<form action="import_moodle.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="option" value="import"/>
		教材名稱：<input type="text" class="btn" name="material_name"/><br/>
		<input type="file" class="btn" name="material"/><br/>
		<input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/>
	</form>
</body>
</html>
