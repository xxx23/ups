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

<center>

{if $rollNum == 0}

<p class="imp">目前無任何點名</p>

{else}

<table class="datatable">
<tr> 
	<th>名稱</th>
	<th>所佔百分比</th>
	<th>日期</th>
	<th>狀態</th>
{if $isShowUnusualListLink == 1}
	<th><div align="center">異常名單</div></th>
{/if}
{if $isModifyOn == 1}
	<th><div align="center">修改</div></th>
{/if}
{if $isDeleteOn == 1}
	<th><div align="center">刪除</div></th>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!-----------------------------------------點名---------------------------------------->
<!------------------------------------------------------------------------------------->


<tr class="tr2">
	<td>點名</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
{if $isShowUnusualListLink == 1}
	<td>&nbsp;</td>
{/if}
{if $isModifyOn == 1}
	<td>&nbsp;</td>
{/if}
{if $isDeleteOn == 1}
	<td>&nbsp;</td>
{/if}
</tr>
{section name=counter loop=$rollCallList}
<tr>
	<td>{$rollCallList[counter].name}</td>
	<td>{$rollCallList[counter].percentage}%</td>
	<td>{$rollCallList[counter].roll_date}</td>
	<td>{if $rollCallList[counter].percentage>0}<span class="imp">記分</span>{else}不計分{/if}</td>	
{if $isShowUnusualListLink == 1}
	<form method="post" action="{$absoluteURL}showOneRollCallStudentUnusualStateList.php">
		<input type="hidden" name="roll_id" value="{$rollCallList[counter].roll_id}">
		<input type="hidden" name="currentPage" value="{$currentPage}">
		<td> <div align="center"><input type="submit" name="submit" value="觀看異常名單" class="btn"></div></td>
	</form>
{/if}
{if $isModifyOn == 1}
	<form method="post" action="{$absoluteURL}modifyRollCall.php">
		<input type="hidden" name="roll_id" value="{$rollCallList[counter].roll_id}">
		<input type="hidden" name="currentPage" value="{$currentPage}">
		<td> <div align="center"><input type="submit" name="submit" value="修改" class="btn"></div></td>
	</form>
{/if}
{if $isDeleteOn == 1}
	<form method="post" action="{$absoluteURL}deleteRollCall.php">
		<input type="hidden" name="roll_id" value="{$rollCallList[counter].roll_id}">
		<td> <div align="center"><input type="submit" name="submit" value="刪除" onClick="return confirm('確定要刪除這項點名以及學員的成績?')" class="btn"></div></td>
	</form>
{/if}
</tr>
{/section}


</table>

{/if}


</div>
</center>

</body>
</html>
