<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{if $action == "new"}
<title>新增系統</title>
{else if  $action == "modify"}
<title>修改系統</title>
{/if}

{literal}
<script language="JavaScript" type="text/javascript">

	function checkData()
	{	
		if(document.getElementById('system_name').value != "")
		{
			document.getElementById('submitButton').disabled = false;
		}
		else
		{
			document.getElementById('submitButton').disabled = true;
		}
	}
	
	function disableSubmit()
	{
		FORM_Post.submitButton.disabled = true;
	}
</script>
{/literal}

</head>

<body>

<center>

{if $action == "new"}
<form name="FORM_Post" method="POST" action="newSystemSave.php">
{else if  $action == "modify"}
<form name="FORM_Post" method="POST" action="modifySystemSave.php">
{/if}

<table class="datatable">
<tr>
	<th>系統編號</th>
	<th>系統名稱</th>
	<th>使用狀況</th>
</tr>
<tr>
	<td align="center">{$system_id}</td>
	<td><input name="system_name" type="text" maxlength="50" size="30" onKeyUp="checkData()" value="{$system_name}"></td>
	<td><select name="system_state" onChange="checkData()">
		<option value="y" {if $system_state == 'y'}selected{/if}>使用</option>
		<option value="n" {if $system_state == 'n'}selected{/if}>不使用</option>
		</select>
	</td>
</tr>
</table>

<input name="system_id" type="hidden" value="{$system_id}">

{if $action == "new"}
<input type="submit" value="新增" name="submitButton" disabled>
{else if $action == "modify"}
<input type="submit" value="修改" name="submitButton" disabled>
{/if}

<input type="reset"  value="清除" onClick="disableSubmit()">

</form>


<hr>


<input type="button" value="回上一頁" onClick="location.href='learningTrackingManagement.php'">

</center>

</body>
</html>
