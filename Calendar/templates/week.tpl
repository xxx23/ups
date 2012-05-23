<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{literal}
<script language="javascript">
<!--
function changeMode(selObj){
	var sel = selObj.options[selObj.selectedIndex];
	switch(sel.value){
		case 'week':
			location.href="./week.php";
			break;
		case 'month':
			location.href="./month.php";
			break;
		default:
			alert("error");
			break;
	}
}


-->
</script>
{/literal}
<title>{$personal_name}的行事曆</title>
</head>

<body>

<!--  顯示上方 -->
{$year}年
<caption>
<a href="./week.php?action=sub&valueY={$year}&valueW={$week}"> &lt;</a>第{$week}週<a href="./week.php?action=add&valueY={$year}&valueW={$week}">&gt;</a> 
</caption>
<select name="mode" onChange="changeMode(this);">
	<option value="month">月瀏覽</option>
	<option value="week" selected>週瀏覽</option>
</select>	
<!-- 顯示下方 -->
<table>
<tr>
	<td>
	<table>
	{foreach from=$data item=datas}	
	<tr bgcolor="#60BF60">
		<td>
		{$datas.0}
		<font color="#FF0000">星期日</font>		
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			
	</tr>
	<tr bgcolor="#60BF60">
		<td>
		{$datas.1}
		<font color="#FFFFFF">星期一</font>		
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>		
	</tr>
	<tr bgcolor="#60BF60">		
		<td>
		{$datas.2}
		<font color="#FFFFFF">星期二</font>		
		</td>	
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			
	</tr>
	<tr bgcolor="#60BF60">		
		<td>
		{$datas.3}
		<font color="#FFFFFF">星期三</font>		
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>					
	</tr>
	<tr bgcolor="#60BF60">		
		<td>
		{$datas.4}
		<font color="#FFFFFF">星期四</font>		
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>					
	</tr>
	<tr bgcolor="#60BF60">		
		<td>
		{$datas.5}
		<font color="#FFFFFF">星期五</font>		
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>					
	</tr>
	<tr bgcolor="#60BF60">				
		<td>
		{$datas.6}
		<font color="#00FF00">星期六</font>		
		</td>	
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			
	</tr>
	{/foreach}		
	</table>
	</td>
</tr>
</table>

<form method="get" name="selectForm" action="./week.php">
移至
<select name="sel_year">
{$sel_year}
</select>
<select name="sel_month">
{$sel_month}
</select>
<select name="sel_day">
{$sel_day}
</select>
<input type="submit" name="submitButton" value="Go!" />						
</form>

</body>
</html>
