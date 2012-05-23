<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>


<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />




<script language="JavaScript" type="text/javascript">
var preLevelNum = {$levelNum};

{literal}
function changeLevelNum(srcObj)
{
	
	for(counter=1; counter<=10;counter++)
	{
		if(counter<srcObj.value)
		{
			eval("document.all.lv" + counter).style.display = "block";
						
			if(counter==preLevelNum)
			{
				eval("document.all.lv" + counter + "_bottom").value = '';
			}	
			eval("document.all.lv" + counter + "_bottom").disabled = 0;		
		}
		else if(counter==srcObj.value)
		{
			eval("document.all.lv" + counter).style.display = "block";
			
			eval("document.all.lv" + counter + "_bottom").value = 0;
			eval("document.all.lv" + counter + "_bottom").disabled = 1;
		}
		else
		{
			eval("document.all.lv" + counter).style.display = "none";
			
			eval("document.all.lv" + counter + "_bottom").value = '';
			eval("document.all.lv" + counter + "_bottom").disabled = 0;
			
			if(counter != 1)
			{
				eval("document.all.lv" + counter + "_top").value = '';
			}
			
			eval("document.all.lv" + counter + "_value").value = '';
		}
	}	
	
	preLevelNum = srcObj.value;
}

function changeBottom(srcObj, tarID)
{
	eval("document.all." + tarID).value = srcObj.value-1;
}

function onSubmit()
{

	var isError = false;
/*	
	for(counter=1; counter<=preLevelNum;counter++)
	{
		if(eval("document.all.lv" + counter + "_bottom").value == '')
		{
			isError = true;
			alert(請設定分數區間);
			
			break;
		}
	
		if(eval("document.all.lv" + counter + "_value").value == '')
		{
			isError = true;
			alert(請設定轉換結果);
			
			break;
		}
	}
*/	
	if(isError == false)
	{
		for(counter=1; counter<=preLevelNum;counter++)
		{
			eval("document.all.lv" + counter + "_bottom").disabled = 0;	
		}
	}

	return (!isError);
}

</script>

{/literal}

</head>

<body>
<h1>{$title}</h1>
	
<form method="POST" action="setupGradeConvertSave.php">

<table class="datatable">
<tr> 
	<th>成績階級數<span class="required">*</span></th>
	<td><select name="levelNum" onchange="changeLevelNum(this)">
			<option value="0" {if $levelNum == 0}selected{/if}>0</option>
			<option value="1" {if $levelNum == 1}selected{/if}>1</option>
			<option value="2" {if $levelNum == 2}selected{/if}>2</option>
			<option value="3" {if $levelNum == 3}selected{/if}>3</option>
			<option value="4" {if $levelNum == 4}selected{/if}>4</option>
			<option value="5" {if $levelNum == 5}selected{/if}>5</option>
			<option value="6" {if $levelNum == 6}selected{/if}>6</option>
			<option value="7" {if $levelNum == 7}selected{/if}>7</option>
			<option value="8" {if $levelNum == 8}selected{/if}>8</option>
			<option value="9" {if $levelNum == 9}selected{/if}>9</option>
			<option value="10" {if $levelNum == 10}selected{/if}>10</option>
		</select>
	</td>
</tr>
</table>

<br>


<table class="datatable">
<tr>
	<th>分數區間</th>
	<th>轉換結果</th>
</tr>

<tr id="lv1" style="display:{if $isShowLv1==1}block{else}none{/if}">
	<td><input type="text" name="lv1_bottom" id="lv1_bottom" value="{$lv1_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv2_top')" onchange="changeBottom(this, 'lv2_top')" {if $levelNum==1}disabled{/if}>-<input type="text" name="lv1_top" id="lv1_top" size="2" maxlength="2" value="100" disabled></td>
	<td><input type="text" name="lv1_value" value="{$lv1_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv2" style="display:{if $isShowLv2==1}block{else}none{/if}">
	<td><input type="text" name="lv2_bottom" id="lv2_bottom" value="{$lv2_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv3_top')" onchange="changeBottom(this, 'lv3_top')" {if $levelNum==2}disabled{/if}>-<input type="text" name="lv2_top" id="lv2_top" size="2" maxlength="2" value="{$lv2_top}" disabled></td>

	<td><input type="text" name="lv2_value" value="{$lv2_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv3" style="display:{if $isShowLv3==1}block{else}none{/if}">
	<td><input type="text" name="lv3_bottom" id="lv3_bottom" value="{$lv3_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv4_top')" onchange="changeBottom(this, 'lv4_top')" {if $levelNum==3}disabled{/if}>-<input type="text" name="lv3_top" id="lv3_top" size="2" maxlength="2" value="{$lv3_top}" disabled></td>

	<td><input type="text" name="lv3_value" value="{$lv3_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv4" style="display:{if $isShowLv4==1}block{else}none{/if}">
	<td><input type="text" name="lv4_bottom" id="lv4_bottom" value="{$lv4_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv5_top')" onchange="changeBottom(this, 'lv5_top')" {if $levelNum==4}disabled{/if}>-<input type="text" name="lv4_top" id="lv4_top" size="2" maxlength="2" value="{$lv4_top}" disabled></td>

	<td><input type="text" name="lv4_value" value="{$lv4_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv5" style="display:{if $isShowLv5==1}block{else}none{/if}">
	<td><input type="text" name="lv5_bottom" id="lv5_bottom" value="{$lv5_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv6_top')" onchange="changeBottom(this, 'lv6_top')" {if $levelNum==5}disabled{/if}>-<input type="text" name="lv5_top" id="lv5_top" size="2" maxlength="2" value="{$lv5_top}" disabled></td>

	<td><input type="text" name="lv5_value" value="{$lv5_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv6" style="display:{if $isShowLv6==1}block{else}none{/if}">
	<td><input type="text" name="lv6_bottom" id="lv6_bottom" value="{$lv6_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv7_top')" onchange="changeBottom(this, 'lv7_top')" {if $levelNum==6}disabled{/if}>-<input type="text" name="lv6_top" id="lv6_top" size="2" maxlength="2" value="{$lv6_top}" disabled></td>

	<td><input type="text" name="lv6_value" value="{$lv6_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv7" style="display:{if $isShowLv7==1}block{else}none{/if}">
	<td><input type="text" name="lv7_bottom" id="lv7_bottom" value="{$lv7_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv8_top')" onchange="changeBottom(this, 'lv8_top')" {if $levelNum==7}disabled{/if}>-<input type="text" name="lv7_top" id="lv7_top" size="2" maxlength="2" value="{$lv7_top}" disabled></td>

	<td><input type="text" name="lv7_value" value="{$lv7_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv8" style="display:{if $isShowLv8==1}block{else}none{/if}">
	<td><input type="text" name="lv8_bottom" id="lv8_bottom" value="{$lv8_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv9_top')" onchange="changeBottom(this, 'lv9_top')" {if $levelNum==8}disabled{/if}>-<input type="text" name="lv8_top" id="lv8_top" size="2" maxlength="2" value="{$lv8_top}" disabled></td>

	<td><input type="text" name="lv8_value" value="{$lv8_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv9" style="display:{if $isShowLv9==1}block{else}none{/if}">
	<td><input type="text" name="lv9_bottom" id="lv9_bottom" value="{$lv9_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv10_top')" onchange="changeBottom(this, 'lv10_top')" {if $levelNum==9}disabled{/if}>-<input type="text" name="lv9_top" id="lv9_top" size="2" maxlength="2" value="{$lv9_top}" disabled></td>

	<td><input type="text" name="lv9_value" value="{$lv9_value}" size="5" maxlength="10"></td>
</tr>

<tr id="lv10" style="display:{if $isShowLv10==1}block{else}none{/if}">
	<td><input type="text" name="lv10_bottom" id="lv10_bottom" value="{$lv10_bottom}" size="2" maxlength="2" onkeyup="changeBottom(this, 'lv11_top')" onchange="changeBottom(this, 'lv11_top')" {if $levelNum==10}disabled{/if}>-<input type="text" name="lv10_top" id="lv10_top" size="2" maxlength="2" value="{$lv10_top}" disabled></td>

	<td><input type="text" name="lv10_value" value="{$lv10_value}" size="5" maxlength="10"></td>
</tr>


</table>
<p class="intro">ex:&nbsp;0-59&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;不及格<br>&nbsp;&nbsp;60-100&nbsp;及格</p>
<p class="al-left">
<input type="hidden" name="grade_type_cd" value="{$grade_type_cd}">
<input type="reset" name="Reset" value="清除資料" class="btn">
<input type="submit" name="Submit" value="確定送出" class="btn" onclick="return onSubmit()">
{if $isBackOn == 1}
<input type="button" name="back" value="回上一頁" onclick="location.href='{$incomingPage}'" class="btn">
{/if}</p>
</form>

</body>
</html>
