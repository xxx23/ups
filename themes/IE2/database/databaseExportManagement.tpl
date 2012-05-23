<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>資料庫匯出</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script language="JavaScript" type="text/javascript">

	function tableTargetOnClick()
	{
		if(document.getElementById('tableTarget').checked == true)
		{
{/literal}
<!---------------------資料表 列表------------------------->
{section name=counter loop=$tableList}
			document.getElementById('table_{$tableList[counter].counter}').checked = true;
{/section}
<!------------------------------------------------------->
{literal}
		}
		else
		{
{/literal}
<!---------------------資料表 列表------------------------->
{section name=counter loop=$tableList}
			document.getElementById('table_{$tableList[counter].counter}').checked = false;
{/section}
<!------------------------------------------------------->
{literal}
		}
	}

	function submitCheck()
	{
		if(	document.getElementById('sql_create').checked == false && 
			document.getElementById('sql_insert').checked == false
			)
		{
			document.getElementById('submit').disabled = true;
		}
		else
		{
			document.getElementById('submit').disabled = false;
		}
	}
	
</script>
{/literal}

</head>

<body>

<center>


<h1>資料庫匯出</h1>

<p>
<form method="POST" action="databaseExport.php">
<input type="checkbox" name="sql_create" id="sql_create" value="1" onClick="submitCheck()">匯出結構
<input type="checkbox" name="sql_insert" id="sql_insert" value="1" onClick="submitCheck()">匯出資料
</p>

<table border="1">
<tr>
	<td>目標：<input type="checkbox" id="tableTarget" value="all" onClick="tableTargetOnClick()">所有表格<br></td>
</tr>
<tr>
	<td align="left">
<!---------------------資料表 列表------------------------->
{section name=counter loop=$tableList}
	
	<input type="checkbox" name="table_{$tableList[counter].counter}" id="table_{$tableList[counter].counter}" value="{$tableList[counter].tableName}">{$tableList[counter].tableName}<br>

{/section}
<!------------------------------------------------------->
	</td>
</tr>
</table>

<br>

<input type="submit" value="確定" name="submit" disabled>
<input type="reset" value="清除">

<input type="hidden" name="tableNumber" value="{$tableNumber}">
</form>

<br>

</center>

</body>
</html>
