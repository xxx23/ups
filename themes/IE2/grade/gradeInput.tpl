
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
<h1>{$title}</h1>
{if $action=='new'}
<form method="POST" action="newGradeSave.php">
{elseif $action=='modify'}
<form method="POST" action="modifyGradeSave.php">
<input type="hidden" name="number_id" value="{$number_id}">
{/if}

<table class="datatable">
<tr>
{if $action=='new'}
	<th>名稱<span class='required'>*</th>
	<td><input type="text" name="name" value="請輸入名稱" size="15" maxlength="15"></td>

	<th>類型<span class='required'>*</span></th>
	<td>

		<select name="percentage_type">
			<option value="4">一般測驗</option>
			<option value="5">一般作業</option>
			<option value="9">其他</option>
		</select>
	</td>

{/if}
	<th>所佔百分比<span class='required'>*</span></th>
	<td><input type="text" name="percentage" size="10" value="{$percentage}">%</td>
</tr>
</table>

<br>

{if $isStudentInputOn == 1}
{if $studentNum>0}

<table class="datatable">
<tr> 
	<th>姓名</th>
	<th>成績</th>
</tr>
<!---------------------學生列表------------------------->
{section name=counter loop=$studentList}
<tr class="{cycle values=",tr2"}">	
	<td align="center">{$studentList[counter].personal_name}</td>
	<td align="center">
		
		<input type="text" name="grade_{$studentList[counter].counter}" size="10"  value="{$studentList[counter].grade}">
		<input type="hidden" name="id_{$studentList[counter].counter}" size="10"  value="{$studentList[counter].personal_id}">
	</td>
</tr>
{/section}
</table>

{/if}
{/if}
<P class="al-left">
<input type="hidden" name="studentNum" value="{$studentNum}">
<input type="reset" name="Reset" value="清除資料" class="btn">
<input type="submit" name="Submit" value="確定送出" class="btn">
{if $isBackOn == 1}
<input type="button" name="back" value="回上一頁" onclick="location.href='{$incomingPage}'" class="btn">
{/if}</P>
</form>

</body>
</html>
