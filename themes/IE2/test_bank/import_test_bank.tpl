<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/test_bank/import.js"></script>
</head>

<body>
<fieldset>
<legend><img src="{$tpl_path}/images/icon/import.gif"/>題庫名稱：{$test_bank_name}</legend>
<form action="import_test_bank.php" method="POST" enctype="multipart/form-data" id="form_import">
<input type="hidden" name="content_cd" value="{$content_cd}"/>
<input type="hidden" name="option" value="import"/>
<input type="hidden" name="test_bank_id" value="{$test_bank_id}"/>
<input type="file" name="import" class="btn"/><input type="submit" value="確定送出" class="btn"/>
<img src="{$tpl_path}/images/icon/proceeding.gif" id="p_im"/>
</form>
<a href="test_bank.php"><img src="{$tpl_path}/images/icon/return.gif"/>返回題庫選擇頁面</a>
</fieldset>
</body>

</html>
