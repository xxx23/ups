<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生點名列表</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>


<center>

<a href="{$absoluteURL}createAllStudentRollCallStateListExcel.php">檔案下載</a>
<br>

<table class="datatable">
<tr>
	<th>姓名</th>
{if $rollCallNum>0}
{section name=counter loop=$rollCallList}
	<th>{$rollCallList[counter].name}({$rollCallList[counter].percentage}%)</th>
{/section}
{/if}

{if $studentNum>0}
{section name=counter loop=$studentList}
<tr class="{cycle values=",tr2"}">
	<td>{$studentList[counter].name}</td>
{if $rollCallNum>0} 
	{section name=counter2 loop=$studentRollCallList[counter]}
	<td>
		{if $studentRollCallList[counter][counter2]==-1}<font color="#FF0000">無資料</font>{/if}
		{if $studentRollCallList[counter][counter2]==0}出席{/if}
		{if $studentRollCallList[counter][counter2]==1}<span class="imp">缺席</span>{/if}
		{if $studentRollCallList[counter][counter2]==2}<span class="imp">遲到</span>{/if}
		{if $studentRollCallList[counter][counter2]==3}<span class="imp">早退</span>{/if}
		{if $studentRollCallList[counter][counter2]==4}<span class="imp">請假</span>{/if}
		{if $studentRollCallList[counter][counter2]==5}<span class="imp">其他</span>{/if}
	</td>
	{/section}
{/if}
{/section}
</tr>
</table>
{/if}

</center>

</body>
</html>
