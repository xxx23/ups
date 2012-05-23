<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<title>教材勘誤頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/JavaScript">

function conti(content_cd)
{
    var url="textbook_error_report_2.php?content_cd="+content_cd;
    window.location=url;
}
function bye()
{
    alert("感謝您的回報!");
    window.close();
}
</script>
{/literal}
</head>
<body class="ifr" id="tabA">
<h1>教材勘誤頁面</h1>
<div class="tab">
<ul id="tabnav">
<li class="tabA" >{$Caption}&nbsp;教材錯誤回報</li>
</ul>
</div>
<div>
    {*<table align="center" width=400 height="300" border="1">*}
    <table class="datatable">
    <tr>
    <td width=100 align="center">回報者</td>
    <td><input type="text" name="reporter" value={$reporter} disabled></td></tr>
    <tr>
    <td width=100 align="center">章節</td>
    <td><input type="text" size="30" name="chapter" value={$chapter} disabled></td></tr>
    <tr>
    <td width=100 align="center">頁數</td>
    <td><input type="text" name="page" value={$page} disabled></td></tr>
    <tr>
    <td width=100 align="center">內容</td>
    <td><input type="text" name="content" value={$content} disabled></td></tr>
    <tr>
    <td colspan="2" width=100% align="center"><input type="button" value="繼續填寫" onclick="conti({$content_cd});"></td>
  {*  <td width=100% align="right"><input type="button" value="完成" onclick="bye();"></td>*}
    </tr>
    </table>
</div>

</body>
</html>
