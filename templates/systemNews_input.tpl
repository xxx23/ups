<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>新增公告</title>


{literal}
<script language="JavaScript">
	function formTypeAction()
	{
		document.FORM_type.submit();
	}
	
	function check()
	{
		if(FORM_PostNews.subject.value == "" || FORM_PostNews.content.value == "")
		{
			FORM_PostNews.submit.disabled = true;
		}
		else
		{
			FORM_PostNews.submit.disabled = false;
		}
	}
</script>
{/literal}

</head>

<center>
<table border="0" cellspacing="1" cellpadding="5">
<tr bgcolor="#000066">
	
	<form name="FORM_type" method="POST" action="./systemNews_new.php">
	<td>	
		<div align="center">
		<font color="#FFFFFF" size="2">
		公告類型：
		<select name="formType" onChange="formTypeAction()">
		<option value="1" {if $formType == 1} selected {/if} >一般性</option>
		<option value="2" {if $formType == 2} selected {/if} >時限性</option>
		<option value="3" {if $formType == 3} selected {/if} >週期性</option>
		</select>
		</font>
		</div>
	</td>
	</form>

	<form name="FORM_PostNews" method="POST" action="./systemNews_newSave.php" >
	<input name="formType" type="hidden" value="{$formType}">
	<td>
		<div align="center">
		<font color="#FFFFFF" size="2">重要等級： 
		<select name="important">
			<option value="2">高</option>
			<option value="1" selected>中</option>
			<option value="0">低</option>
		</select>
		</font>
		</div>
	</td>
</tr>
<tr bgcolor="#000066"> 
	<td {if $formType == 1} colspan="2" {else} colspan="1" {/if}>
		<div align="center">
		<font color="#FFFFFF" size="2">
		起始日期：
		<select name="startYear">
		<option value="{$currentYear}" selected>{$currentYear}</option>
		<option value="{$currentYear+1}">{$currentYear+1}</option>
		<option value="{$currentYear+2}">{$currentYear+2}</option>
		<option value="{$currentYear+3}">{$currentYear+3}</option>
		<option value="{$currentYear+4}">{$currentYear+4}</option>
		</select>年
		
		<select name="startMonth">
		<option value="01" {if $currentMonth == 1} selected {/if}>1</option>
		<option value="02" {if $currentMonth == 2} selected {/if}>2</option>
		<option value="03" {if $currentMonth == 3} selected {/if}>3</option>
		<option value="04" {if $currentMonth == 4} selected {/if}>4</option>
		<option value="05" {if $currentMonth == 5} selected {/if}>5</option>
		<option value="06" {if $currentMonth == 6} selected {/if}>6</option>
		<option value="07" {if $currentMonth == 7} selected {/if}>7</option>
		<option value="08" {if $currentMonth == 8} selected {/if}>8</option>
		<option value="09" {if $currentMonth == 9} selected {/if}>9</option>
		<option value="10" {if $currentMonth == 10} selected {/if}>10</option>
		<option value="11" {if $currentMonth == 11} selected {/if}>11</option>
		<option value="12" {if $currentMonth == 12} selected {/if}>12</option>
		</select>月
		
		<select name="startDay">
		<option value="01" {if $currentDay == 1} selected {/if}>1</option>
		<option value="02" {if $currentDay == 2} selected {/if}>2</option>
		<option value="03" {if $currentDay == 3} selected {/if}>3</option>
		<option value="04" {if $currentDay == 4} selected {/if}>4</option>
		<option value="05" {if $currentDay == 5} selected {/if}>5</option>
		<option value="06" {if $currentDay == 6} selected {/if}>6</option>
		<option value="07" {if $currentDay == 7} selected {/if}>7</option>
		<option value="08" {if $currentDay == 8} selected {/if}>8</option>
		<option value="09" {if $currentDay == 9} selected {/if}>9</option>
		<option value="10" {if $currentDay == 10} selected {/if}>10</option>
		<option value="11" {if $currentDay == 11} selected {/if}>11</option>
		<option value="12" {if $currentDay == 12} selected {/if}>12</option>
		<option value="13" {if $currentDay == 13} selected {/if}>13</option>
		<option value="14" {if $currentDay == 14} selected {/if}>14</option>
		<option value="15" {if $currentDay == 15} selected {/if}>15</option>
		<option value="16" {if $currentDay == 16} selected {/if}>16</option>
		<option value="17" {if $currentDay == 17} selected {/if}>17</option>
		<option value="18" {if $currentDay == 18} selected {/if}>18</option>
		<option value="19" {if $currentDay == 19} selected {/if}>19</option>
		<option value="20" {if $currentDay == 20} selected {/if}>20</option>
		<option value="21" {if $currentDay == 21} selected {/if}>21</option>
		<option value="22" {if $currentDay == 22} selected {/if}>22</option>
		<option value="23" {if $currentDay == 23} selected {/if}>23</option>
		<option value="24" {if $currentDay == 24} selected {/if}>24</option>
		<option value="25" {if $currentDay == 25} selected {/if}>25</option>
		<option value="26" {if $currentDay == 26} selected {/if}>26</option>
		<option value="27" {if $currentDay == 27} selected {/if}>27</option>
		<option value="28" {if $currentDay == 28} selected {/if}>28</option>
		<option value="29" {if $currentDay == 29} selected {/if}>29</option>
		<option value="30" {if $currentDay == 30} selected {/if}>30</option>
		<option value="31" {if $currentDay == 31} selected {/if}>31</option>
		</select>日		
		</font>
		</div>
	</td>
	{if $formType != 1}
	<td>
		<div align="center">
		<font color="#FFFFFF" size="2">
		結束日期：
		<select name="endYear">
		<option value="{$currentYear}" selected>{$currentYear}</option>
		<option value="{$currentYear+1}">{$currentYear+1}</option>
		<option value="{$currentYear+2}">{$currentYear+2}</option>
		<option value="{$currentYear+3}">{$currentYear+3}</option>
		<option value="{$currentYear+4}">{$currentYear+4}</option>
		</select>年
		
		<select name="endMonth">
		<option value="01" {if $currentMonth == 1} selected {/if}>1</option>
		<option value="02" {if $currentMonth == 2} selected {/if}>2</option>
		<option value="03" {if $currentMonth == 3} selected {/if}>3</option>
		<option value="04" {if $currentMonth == 4} selected {/if}>4</option>
		<option value="05" {if $currentMonth == 5} selected {/if}>5</option>
		<option value="06" {if $currentMonth == 6} selected {/if}>6</option>
		<option value="07" {if $currentMonth == 7} selected {/if}>7</option>
		<option value="08" {if $currentMonth == 8} selected {/if}>8</option>
		<option value="09" {if $currentMonth == 9} selected {/if}>9</option>
		<option value="10" {if $currentMonth == 10} selected {/if}>10</option>
		<option value="11" {if $currentMonth == 11} selected {/if}>11</option>
		<option value="12" {if $currentMonth == 12} selected {/if}>12</option>
		</select>月
		
		<select name="endDay">
		<option value="01" {if $currentDay == 1} selected {/if}>1</option>
		<option value="02" {if $currentDay == 2} selected {/if}>2</option>
		<option value="03" {if $currentDay == 3} selected {/if}>3</option>
		<option value="04" {if $currentDay == 4} selected {/if}>4</option>
		<option value="05" {if $currentDay == 5} selected {/if}>5</option>
		<option value="06" {if $currentDay == 6} selected {/if}>6</option>
		<option value="07" {if $currentDay == 7} selected {/if}>7</option>
		<option value="08" {if $currentDay == 8} selected {/if}>8</option>
		<option value="09" {if $currentDay == 9} selected {/if}>9</option>
		<option value="10" {if $currentDay == 10} selected {/if}>10</option>
		<option value="11" {if $currentDay == 11} selected {/if}>11</option>
		<option value="12" {if $currentDay == 12} selected {/if}>12</option>
		<option value="13" {if $currentDay == 13} selected {/if}>13</option>
		<option value="14" {if $currentDay == 14} selected {/if}>14</option>
		<option value="15" {if $currentDay == 15} selected {/if}>15</option>
		<option value="16" {if $currentDay == 16} selected {/if}>16</option>
		<option value="17" {if $currentDay == 17} selected {/if}>17</option>
		<option value="18" {if $currentDay == 18} selected {/if}>18</option>
		<option value="19" {if $currentDay == 19} selected {/if}>19</option>
		<option value="20" {if $currentDay == 20} selected {/if}>20</option>
		<option value="21" {if $currentDay == 21} selected {/if}>21</option>
		<option value="22" {if $currentDay == 22} selected {/if}>22</option>
		<option value="23" {if $currentDay == 23} selected {/if}>23</option>
		<option value="24" {if $currentDay == 24} selected {/if}>24</option>
		<option value="25" {if $currentDay == 25} selected {/if}>25</option>
		<option value="26" {if $currentDay == 26} selected {/if}>26</option>
		<option value="27" {if $currentDay == 27} selected {/if}>27</option>
		<option value="28" {if $currentDay == 28} selected {/if}>28</option>
		<option value="29" {if $currentDay == 29} selected {/if}>29</option>
		<option value="30" {if $currentDay == 30} selected {/if}>30</option>
		</select>日		
		</font>
		</div>
	</td>
	{/if}
</tr>
{if $formType == 3}
<tr bgcolor="#000066">
	<td colspan="2">
		<div align="center"><font color="#FFFFFF" size="2">週期設定： 
		<select name="cycleYear">
			<option value=0000 selected>每年</option>
		<option value="{$currentYear}">{$currentYear}</option>
		<option value="{$currentYear+1}">{$currentYear+1}</option>
		<option value="{$currentYear+2}">{$currentYear+2}</option>
		<option value="{$currentYear+3}">{$currentYear+3}</option>
		<option value="{$currentYear+4}">{$currentYear+4}</option>
		</select>年
		&nbsp;
		<select name="cycleMonth">
			<option value="00" selected>每月</option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>月
		&nbsp;
		<select name="cycleDay">
			<option value="00" selected>每日</option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>日
		&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="cycleWeek">
			<option value="00" selected>無論星期</option>
			<option value="01">星期一</option>
			<option value="02">星期二</option>
			<option value="03">星期三</option>
			<option value="04">星期四</option>
			<option value="05">星期五</option>
			<option value="06">星期六</option>
			<option value="07">星期日</option>
		</select>
	</td>
</tr>
{/if}
<tr bgcolor="#000066"> 
	<td colspan="2"> 
		<div align="center">
		<font color="#FFFFFF" size="2">
		公告標題：
		<input name="subject" type="text" maxlength="50" onKeyUp="check()">
		</font>
		</div>
	</td>
</tr>
<tr> 
	<td colspan="2"> 
		<div align="center">
		<font size="2">
		<br>發佈新消息：<br>
		<textarea name="content" rows="12" cols="55" onKeyUp="check()"></textarea>
		</font></div>
	</td>
</tr>
<tr> 
	<td colspan="2"> 
		<div align="center">
		<font size="2">
		<input type="submit" value="發佈" name="submit" disabled>
		<input type="reset"  value="清除" name="reset">
		</font>
		</div>
	</td>
	</form>
</tr>
</table>
</center>

</body>
</HTML>
