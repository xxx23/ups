<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<legend><h1>查詢點名</h1></legend>

<center>

{if $rollCallNum == 0}

<p class="imp">目前無任何點名</p>

{else}

<table class="datatable">
<tr> 
	<th>名稱</th>
	<th>狀況</th>
	<th>日期</th>
</tr>

{section name=counter loop=$studentRollCallList}
<tr class="{cycle values=",tr2"}">	
	<td>{$studentRollCallList[counter].name}</td>
	<td>
		{if $studentRollCallList[counter].state==-1}無資料{/if}
		{if $studentRollCallList[counter].state==0}出席{/if}
		{if $studentRollCallList[counter].state==1}缺席{/if}
		{if $studentRollCallList[counter].state==2}遲到{/if}
		{if $studentRollCallList[counter].state==3}早退{/if}
		{if $studentRollCallList[counter].state==4}請假{/if}
		{if $studentRollCallList[counter].state==5}其他{/if}
	</td>
	<td>{$studentRollCallList[counter].roll_date}</td>
</tr>
{/section}

</table>

{/if}


</div>
</center>

</body>
</html>
