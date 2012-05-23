<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>作業解答</h1><br/>
<fieldset><legend>作業名稱：{$name}</legend>
<div>解答: <br /><br /> {$answer} </div></fieldset>
<fieldset><legend>相關檔案</legend>
  <table class="form">
    {foreach from=$file_data item=file}
    <tr>
      <td><a href="{$file.path}" target="_blank">{$file.name}</a></td>
    </tr>
    {/foreach}
  </table>
</fieldset><p class="al-left"><a href="stu_assign_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>

</body>
</html>
