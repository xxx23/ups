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

<center>

<fieldset>
	<legend><h1>{$title}</h1></legend>

{if $action=='new'}
<form method="POST" action="newRollCallSave.php">
{elseif $action=='modify'}
<form method="POST" action="modifyRollCallSave.php">
<input type="hidden" name="roll_id" value="{$roll_id}">
{/if}

<table class="datatable">
<tr>
	<th>日期<span class='required'>*</span></th>
	<td align="left">
		<select name="year">
		{section name=counter loop=$yearScope}
		<option value="{$yearScope[counter]}" {if $year == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
		{/section}
		</select>年
		
		<select name="month">
		<option value="01" {if $month == '01'} selected {/if}>1</option>
		<option value="02" {if $month == '02'} selected {/if}>2</option>
		<option value="03" {if $month == '03'} selected {/if}>3</option>
		<option value="04" {if $month == '04'} selected {/if}>4</option>
		<option value="05" {if $month == '05'} selected {/if}>5</option>
		<option value="06" {if $month == '06'} selected {/if}>6</option>
		<option value="07" {if $month == '07'} selected {/if}>7</option>
		<option value="08" {if $month == '08'} selected {/if}>8</option>
		<option value="09" {if $month == '09'} selected {/if}>9</option>
		<option value="10" {if $month == '10'} selected {/if}>10</option>
		<option value="11" {if $month == '11'} selected {/if}>11</option>
		<option value="12" {if $month == '12'} selected {/if}>12</option>
		</select>月
		
		<select name="day">
		<option value="01" {if $day == '01'} selected {/if}>1</option>
		<option value="02" {if $day == '02'} selected {/if}>2</option>
		<option value="03" {if $day == '03'} selected {/if}>3</option>
		<option value="04" {if $day == '04'} selected {/if}>4</option>
		<option value="05" {if $day == '05'} selected {/if}>5</option>
		<option value="06" {if $day == '06'} selected {/if}>6</option>
		<option value="07" {if $day == '07'} selected {/if}>7</option>
		<option value="08" {if $day == '08'} selected {/if}>8</option>
		<option value="09" {if $day == '09'} selected {/if}>9</option>
		<option value="10" {if $day == '10'} selected {/if}>10</option>
		<option value="11" {if $day == '11'} selected {/if}>11</option>
		<option value="12" {if $day == '12'} selected {/if}>12</option>
		<option value="13" {if $day == '13'} selected {/if}>13</option>
		<option value="14" {if $day == '14'} selected {/if}>14</option>
		<option value="15" {if $day == '15'} selected {/if}>15</option>
		<option value="16" {if $day == '16'} selected {/if}>16</option>
		<option value="17" {if $day == '17'} selected {/if}>17</option>
		<option value="18" {if $day == '18'} selected {/if}>18</option>
		<option value="19" {if $day == '19'} selected {/if}>19</option>
		<option value="20" {if $day == '20'} selected {/if}>20</option>
		<option value="21" {if $day == '21'} selected {/if}>21</option>
		<option value="22" {if $day == '22'} selected {/if}>22</option>
		<option value="23" {if $day == '23'} selected {/if}>23</option>
		<option value="24" {if $day == '24'} selected {/if}>24</option>
		<option value="25" {if $day == '25'} selected {/if}>25</option>
		<option value="26" {if $day == '26'} selected {/if}>26</option>
		<option value="27" {if $day == '27'} selected {/if}>27</option>
		<option value="28" {if $day == '28'} selected {/if}>28</option>
		<option value="29" {if $day == '29'} selected {/if}>29</option>
		<option value="30" {if $day == '30'} selected {/if}>30</option>
		<option value="31" {if $day == '31'} selected {/if}>31</option>
		</select>日
	</td>
</tr>
<tr> 
	<th>所佔百分比<span class='required'>*</span></th>
	<td align="left"><input type="text" name="percentage" size="10" value="{$percentage}">%</td>
</tr>
</table>

<br>

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
<br>

<input type="hidden" name="studentNum" value="{$studentNum}">
<input type="submit" name="Submit" value="確定" class="btn">
<input type="reset" name="Reset" value="清除" class="btn">
{if $isBackOn == 1}
<input type="button" name="back" value="回上一頁" onclick="location.href='{$incomingPage}'" class="btn">
{/if}
</form>

</fieldset>

</center>

</body>
</html>
