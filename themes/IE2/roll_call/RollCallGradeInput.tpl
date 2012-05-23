<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>設定點名狀態配分</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<center>

<fieldset>
	<legend><h1>設定點名狀態配分</h1></legend>

<form method="POST" action="setupRollCallGradeSave.php">

<table class="datatable">
<tr> 
	<th>狀態</th>
	<th>成績</th>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">出席</td>
	<td align="center">
		<input type="text" name="grade_1" size="10" value="{$statusList[0].status_grade}">
	</td>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">缺席</td>
	<td align="center">
		<input type="text" name="grade_2" size="10" value="{$statusList[1].status_grade}">
	</td>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">遲到</td>
	<td align="center">
		<input type="text" name="grade_3" size="10" value="{$statusList[2].status_grade}">
	</td>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">早退</td>
	<td align="center">
		<input type="text" name="grade_4" size="10" value="{$statusList[3].status_grade}">
	</td>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">請假</td>
	<td align="center">
		<input type="text" name="grade_5" size="10" value="{$statusList[4].status_grade}">
	</td>
</tr>

<tr class="{cycle values=",tr2"}">	
	<td align="center">其他</td>
	<td align="center">
		<input type="text" name="grade_6" size="10" value="{$statusList[5].status_grade}">
	</td>
</tr>

</table>

<br>
<input type="submit" name="Submit" value="確定" class="btn">
<input type="reset" name="Reset" value="清除" class="btn">

</form>

</fieldset></center>

</body>
</html>
