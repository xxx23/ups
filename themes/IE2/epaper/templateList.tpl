<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>電子報樣板列表</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	window.name = 'rootWindow';
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	window.remoteWindow.window.focus();
}

</script>
{/literal}

</head>

<body>
<h1>電子報樣板列表</h1>
<table class="datatable">
<tr>
	<th scope="col">編號</th>
	<th scope="col">描述</th>
</tr>
<tr>
	<td><a href="javascript:pop('showTemplate.php?templateNumber=1','1','width=550,height=400,scrollbars,resizable')">樣式1</a></td>
	<td>樣板1</td>
</tr>
<tr>
	<td><a href="javascript:pop('showTemplate.php?templateNumber=2','1','width=550,height=400,scrollbars,resizable')">樣式2</a></td>
	<td>樣板2</td>
</tr>
</table>

</center>

</body>
</html>
