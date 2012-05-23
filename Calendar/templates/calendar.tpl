<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/calendar.css" rel="stylesheet" type="text/css" />
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />

<script language="javascript">
var inCourse;
{$in_course}
{literal}
<!--
function goto(obj, year, month, day){
	if(inCourse){
		var tmp = document.getElementsByName('information')[0];
		//alert(tmp.innerHTML);
		top.frames['information'].location.href = "./month.php?sel_year="+year+"&sel_month="+month+"&sel_day="+day;
	}else
		top.frames['main_info'].location.href = "./month.php?sel_year="+year+"&sel_month="+month+"&sel_day="+day;
}

function setFocus(obj){
	obj.style.backgroundColor = "#FFFFBF";
}

function unsetFocus(obj){
	obj.style.backgroundColor = "";
}

function changeByMonth(month){
	var year = document.getElementById('sel_year').value;
	location.href="./calendar.php?action=change&valueY="+year+"&valueM="+month;
}

function changeByYear(year){
	var month = document.getElementById('sel_month').value;
	location.href="./calendar.php?action=change&valueY="+year+"&valueM="+month;
}
-->
{/literal}
</script>
<title>{$personal_name}的行事曆</title>
</head>

<body class="cal">
<table class="clmonth">
<caption>
<a href="./calendar.php?action=sub&target=month&valueY={$year}&valueM={$month}">&lt;</a>
<select id="sel_month" name="sel_month" onChange="changeByMonth(this.value);">
{$sel_month}
</select>
<select id="sel_month" name="sel_year" onChange="changeByYear(this.value);">
{$sel_year}
</select>
<a href="./calendar.php?action=add&target=month&valueY={$year}&valueM={$month}">&gt;</a>
</caption>	
	<tr>
		<th scope="col">日</th>
		<th scope="col">一</th>
		<th scope="col">二</th>
		<th scope="col">三</th>
		<th scope="col">四</th>
		<th scope="col">五</th>
		<th scope="col">六</th>
	</tr>	
	{foreach from=$week item=weeks}	
	<tr>
		{$weeks.0}
		{$weeks.1}
		{$weeks.2}
		{$weeks.3}
		{$weeks.4}
		{$weeks.5}
		{$weeks.6}					
	</tr>
	{/foreach}
</table>
<a href="#" class="to" onClick="location.href='./calendar.php';" >今天</a>

</body>
</html>
