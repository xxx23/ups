<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>

<center>

<fieldset>
	<legend><h1>{$title}</h1></legend>


{if $studentNum>0}

<table class="datatable">
<tr> 
	<th>姓名</th>
	<th>狀況</th>
</tr>
<!---------------------學生列表------------------------->
{section name=counter loop=$studentList}
<tr class="{cycle values=",tr2"}">	
	<td align="center">{$studentList[counter].personal_name}</td>
	<td align="center">
		<select name="state_{$studentList[counter].counter}">
			<option value="0" {if $studentList[counter].state==0}selected{/if}>出席</option>
			<option value="1" {if $studentList[counter].state==1}selected{/if}>缺席</option>
			<option value="2" {if $studentList[counter].state==2}selected{/if}>遲到</option>
			<option value="3" {if $studentList[counter].state==3}selected{/if}>早退</option>
			<option value="4" {if $studentList[counter].state==4}selected{/if}>請假</option>
			<option value="5" {if $studentList[counter].state==5}selected{/if}>其他</option>
		</select>		
		<input type="hidden" name="id_{$studentList[counter].counter}" value="{$studentList[counter].personal_id}">
	</td>
</tr>
{/section}
</table>

{/if}

<br><br>

{if $isBackOn == 1}
<input type="button" name="back" value="回上一頁" onclick="location.href='{$incomingPage}'" class="btn">
{/if}


</fieldset>

</center>

</body>
</html>
