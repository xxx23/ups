<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材勘誤回報列表</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script>
</script>

</head>

<body class="ifr" id="tabA">
<h1>教材勘誤回報列表</h1>
<div class="tab">
<ul id="tabnav">
<li class="tabA" >{$Caption}&nbsp;教材回報列表</li>
</ul>
<div class="inner_contentA" id="inner_contentA">
<legend></legend>

<table class="datatable" width="100%" border="1">
{*<caption>                       {#caption_1#}({#total#}{$cnt}{#counts#})              </caption>*}
<caption>勘誤已確認列表  共{$cnt}筆 </caption>
<tr>
<th width="15%">章節 </th>
<th width="10%">頁數 </th>
<th width="15%">勘誤者 </th>
<th width="60%">勘誤內容 </th>
</tr>
{foreach from = $content2 item = element name=contentloop}
    <tr  class="{cycle values=" ,tr2"}">
    <td><img src="{$webroot}images/folderopen.gif">{$element.caption} </td>
    <td>{$element.page}</td>
    <td>{$element.login_id}</td>
    <td>{$element.content}</td>
    </tr>
{/foreach}
</table>
&nbsp;
<table class="datatable" width="100%" border="1">
<caption>勘誤尚未確認列表  共{$cnt1}筆 </caption>
<tr>
<th width="15%">章節 </th>
<th width="10%">頁數 </th>
<th width="15%">勘誤者 </th>
<th width="60%">勘誤內容 </th>
</tr>
{foreach from = $content3 item = element name=contentloop}
    <tr  class="{cycle values=" ,tr2"}">
    <td><img src="{$webroot}images/folderopen.gif">{$element.caption} </td>
    <td>{$element.page}</td>
    <td>{$element.login_id}</td>
    <td>{$element.content}</td>
    </tr>
{/foreach}
</table>
&nbsp;
<table class="datatable" width="100%" border="1">
<caption>勘誤被拒絕列表  共{$cnt2}筆 </caption>
<tr>
<th width="15%">章節 </th>
<th width="10%">頁數 </th>
<th width="15%">勘誤者 </th>
<th width="60%">勘誤內容 </th>
</tr>
{foreach from = $content4 item = element name=contentloop}
    <tr  class="{cycle values=" ,tr2"}">
    <td><img src="{$webroot}images/folderopen.gif">{$element.caption} </td>
    <td>{$element.page}</td>
    <td>{$element.login_id}</td>
    <td>{$element.content}</td>
    </tr>
{/foreach}
</table>
</div>
</div>

</body>
</html>
