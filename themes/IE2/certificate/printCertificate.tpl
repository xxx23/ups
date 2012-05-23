<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$title}</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>列印證書</h1>

<br>

{if $allowPrint == 0}

<div class="imp">請先設定證書</div>

{elseif $studentNum<=0}

<div class="imp">此課程無任何學生</div>

{elseif $studentNum>0}

<form method="POST" action="printCertificateAction.php">
<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}">
<input type="hidden" name="studentNum" value="{$studentNum}">

<table class="datatable">
<tr> 
	<th>列印</th>
	<th>姓名</th>	
</tr>
<!---------------------學生列表--------------------->
{section name=counter loop=$studentList}
<tr class="{cycle values=",tr2"}">	
	<td align="center">
		<input type="checkbox" name="print_{$studentList[counter].counter}" checked>
		<input type="hidden" name="id_{$studentList[counter].counter}" size="10"  value="{$studentList[counter].personal_id}">
	</td>
	<td align="center">{$studentList[counter].personal_name}</td>
</tr>
{/section}
</table>


<P class="al-left">
<input type="submit" name="Submit" value="確定" class="btn">
<input type="reset" name="Reset" value="清除" class="btn">
</P>

</form>

{/if}


</body>
</html>
