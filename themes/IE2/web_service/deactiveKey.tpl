<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Service</title>
		<link type="text/css" href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" />
		<link type="text/css" href="{$tpl_path}/css/content_course.css" rel="stylesheet" />
		<link type="text/css" href="{$webroot}/css/webservice.css" rel="stylesheet" />
        <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
		<link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet">
		<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
</head>

<body>
<div class="searchlist">
<form method="post" action="?action=deactiveKey" name="browsUser">
    <input name="user_id" type="hidden" value="{$user_id}"/>
    <input name="api_key" type="hidden" value="{$api_key}"/>
    <label>不通過原因:</label>
    <textarea name="reason" type="textarea" />{$reason}</textarea>
    {if $errors.reason eq true}<span class="form-error">*不可為空</span>{/if}
    <input name="searchIt" value="送出" type="submit"/>
</form>
</div>
</body>
</html>
