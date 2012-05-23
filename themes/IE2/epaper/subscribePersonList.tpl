<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>訂閱名單</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}



<script type="text/JavaScript">

</script>



{/literal}


{literal}
<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	//window.name = 'rootWindow';
	window.remoteWindow.window.focus();
}

</script>
{/literal}

</head>

<body>
<h1>電子報訂閱名單</h1>
<table class="datatable">
<tr>
	<th>編號</th>
	<th>姓名</th>
	<th>E-mail</th>
</tr>

<!---------------------電子報列表------------------------->
{section name=counter loop=$personList}
<tr class="{cycle values=",tr2"}">
	<td>{counter}</td>
	<td><a href="javascript:pop('{$personList[counter].personal_home}','remoteWindow','width=550,height=400,scrollbars,resizable')">{$personList[counter].personal_name}</a></td>
	<td><a href="mailto:{$personList[counter].email}">{$personList[counter].email}</a></td>
</tr>
{/section}
<!-------------------------------------------------------->
</table>


</body>
</html>
