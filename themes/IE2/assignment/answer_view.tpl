<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>作業名稱：{$name}</h1>
<fieldset>
<legend>{$title}回答</legend>
<div> {$answer} </div>
</fieldset>
<fieldset>
<legend>相關檔案</legend>
<table class="form">
  {foreach from=$file_data item=file}
  <tr>
    <td><a href="{$webroot}library/redirect_file.php?file_name={$file.path}">{$file.name}</a></td>
  </tr>
  {/foreach}
  </tbody>
</table>
</fieldset>
<p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>
</body>
</html>
