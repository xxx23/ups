<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>發布電子報</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>發布電子報</h1>
	
    <table class='datatable'>
	<form method="POST" action="publishEPaperSave.php">
	<input type="hidden" name="behavior" value="{$behavior}">
	<input type="hidden" name="epaper_cd" value="{$epaper_cd}">
	<tr>
		<th>發送日期</th>
		<td>		
			<input type="radio" name="if_auto" value="N" {if $if_auto=='N'}checked{/if}>不自動發送
			<br>
			<input type="radio" name="if_auto" value="Y" {if $if_auto=='Y'}checked{/if}>隨日期自動發送
			
			<select name="startYear">
			{section name=counter loop=$yearScope}
			<option value="{$yearScope[counter]}" {if $startYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
			{/section}
			</select>年
			
			<select name="startMonth">
			<option value="01" {if $startMonth == '01'} selected {/if}>1</option>
			<option value="02" {if $startMonth == '02'} selected {/if}>2</option>
			<option value="03" {if $startMonth == '03'} selected {/if}>3</option>
			<option value="04" {if $startMonth == '04'} selected {/if}>4</option>
			<option value="05" {if $startMonth == '05'} selected {/if}>5</option>
			<option value="06" {if $startMonth == '06'} selected {/if}>6</option>
			<option value="07" {if $startMonth == '07'} selected {/if}>7</option>
			<option value="08" {if $startMonth == '08'} selected {/if}>8</option>
			<option value="09" {if $startMonth == '09'} selected {/if}>9</option>
			<option value="10" {if $startMonth == '10'} selected {/if}>10</option>
			<option value="11" {if $startMonth == '11'} selected {/if}>11</option>
			<option value="12" {if $startMonth == '12'} selected {/if}>12</option>
			</select>月
			
			<select name="startDay">
			<option value="01" {if $startDay == '01'} selected {/if}>1</option>
			<option value="02" {if $startDay == '02'} selected {/if}>2</option>
			<option value="03" {if $startDay == '03'} selected {/if}>3</option>
			<option value="04" {if $startDay == '04'} selected {/if}>4</option>
			<option value="05" {if $startDay == '05'} selected {/if}>5</option>
			<option value="06" {if $startDay == '06'} selected {/if}>6</option>
			<option value="07" {if $startDay == '07'} selected {/if}>7</option>
			<option value="08" {if $startDay == '08'} selected {/if}>8</option>
			<option value="09" {if $startDay == '09'} selected {/if}>9</option>
			<option value="10" {if $startDay == '10'} selected {/if}>10</option>
			<option value="11" {if $startDay == '11'} selected {/if}>11</option>
			<option value="12" {if $startDay == '12'} selected {/if}>12</option>
			<option value="13" {if $startDay == '13'} selected {/if}>13</option>
			<option value="14" {if $startDay == '14'} selected {/if}>14</option>
			<option value="15" {if $startDay == '15'} selected {/if}>15</option>
			<option value="16" {if $startDay == '16'} selected {/if}>16</option>
			<option value="17" {if $startDay == '17'} selected {/if}>17</option>
			<option value="18" {if $startDay == '18'} selected {/if}>18</option>
			<option value="19" {if $startDay == '19'} selected {/if}>19</option>
			<option value="20" {if $startDay == '20'} selected {/if}>20</option>
			<option value="21" {if $startDay == '21'} selected {/if}>21</option>
			<option value="22" {if $startDay == '22'} selected {/if}>22</option>
			<option value="23" {if $startDay == '23'} selected {/if}>23</option>
			<option value="24" {if $startDay == '24'} selected {/if}>24</option>
			<option value="25" {if $startDay == '25'} selected {/if}>25</option>
			<option value="26" {if $startDay == '26'} selected {/if}>26</option>
			<option value="27" {if $startDay == '27'} selected {/if}>27</option>
			<option value="28" {if $startDay == '28'} selected {/if}>28</option>
			<option value="29" {if $startDay == '29'} selected {/if}>29</option>
			<option value="30" {if $startDay == '30'} selected {/if}>30</option>
			<option value="31" {if $startDay == '31'} selected {/if}>31</option>
			</select>日
		</td>
	</tr>
	
	<tr>
		<td align="center" colspan="2"><p class="al-left">
			<input type="submit" value="確定" class="btn"> 
			<input type="reset"  value="清除" name="reset"  class="btn">
			<input type="button"  value="回上一頁" name="back" onClick="location.href='{$incomingPage}?behavior={$behavior}'" class="btn"> </p>
		</td>
	</tr>
	</form>
</table>

</body>
</html>
