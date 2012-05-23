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
<h1>成績轉換設定</h1>
<table class="datatable">
<tr> 
	<th width="40%">成績類型名稱</th>
{if $isSetupGradeConvertOn == 1}
	<th width="60%">&nbsp;</th>
	{/if}
</tr>
<!------------------------------------------------------------------------------------->
<!------------------------------------線上測驗------------------------------------------>
<!------------------------------------------------------------------------------------->
<tr class="tr2">
	<td width="40%">全部</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="0">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>



<!------------------------------------------------------------------------------------->
<!------------------------------------線上測驗------------------------------------------>
<!------------------------------------------------------------------------------------->
<tr class="">
	<td width="40%">線上測驗</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="1">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!-----------------------------------------線上作業------------------------------------->
<!------------------------------------------------------------------------------------->
<tr class="tr2">
	<td width="40%">線上作業</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="2">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!-----------------------------------------點名---------------------------------------->
<!------------------------------------------------------------------------------------->

<tr class="">
	<td width="40%">點名</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="3">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>


<!------------------------------------------------------------------------------------->
<!----------------------------------------一般測驗-------------------------------------->
<!------------------------------------------------------------------------------------->
<tr class="tr2">
	<td width="40%">一般測驗</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="4">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!----------------------------------------一般作業-------------------------------------->
<!------------------------------------------------------------------------------------->

<tr class="">
	<td width="40%">一般作業</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="5">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!------------------------------------------其他---------------------------------------->
<!------------------------------------------------------------------------------------->

<tr class="tr2">
	<td width="40%">其他</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="9">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>

<!------------------------------------------------------------------------------------->
<!-----------------------------------------總成績--------------------------------------->
<!------------------------------------------------------------------------------------->

<tr class="">
	<td width="40%">總成績</td>
{if $isSetupGradeConvertOn == 1}
	<td width="60%"><form method="post" action="setupGradeConvert.php">
		<input type="hidden" name="grade_type_cd" value="99">
		<input type="hidden" name="currentPage" value="{$currentPage}">
	    <input type="submit" name="submit" value="成績轉換設定" class="btn">
	</form></td>
{/if}
</tr>
</table>
</body>
</html>
