<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/survey/port.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>問卷題庫匯出/匯入</h1>
<fieldset>
<legend><img src="{$tpl_path}/images/icon/export.gif"/>問卷題庫匯出</legend>
{if $exist == 1}
<input type="button" class="btn" value="匯出" id="export" onclick="_export({$bankno});"/>
<img src="{$tpl_path}/images/icon/proceeding.gif" id="p_ex"/>
<span id="span_export"><a href="{$webroot}library/redirect_file.php?file_name={$file_name}"/>問卷題庫.xls<img src="{$tpl_path}/images/icon/download.gif"/></a></span>
{else}
目前並無任何問卷題目
{/if}
</fieldset>
<fieldset>
<legend><img src="{$tpl_path}/images/icon/import.gif"/>問卷題庫匯入</legend>
{if $done == 1}<div NAME="ok"  style="color:red;text-align:center;">匯入完成</div>{/if}
<input type="button" value="匯入" class="btn" id="import"/>
<form action="import.php" method="POST" enctype="multipart/form-data" id="form_import">
<input type="file" name="bank" class="btn"/>
<input type="submit" value="確定送出" class="btn"/>
<img src="{$tpl_path}/images/icon/proceeding.gif" id="p_im"/>
</form>
<hr/>
<legend>匯入範例</legend>
<div>
<a href="./{$example_file}">範例檔.xls<img src="{$tpl_path}/images/icon/download.gif"/></a>


<h2>範例匯入結果如下:</h2>
<img src="{$tpl_path}/images/survey.png">
</div>
</fieldset>

</body>

<html>
