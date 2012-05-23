<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>設定成績單</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}

<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	//window.name = 'rootWindow';
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	window.remoteWindow.window.focus();
}

</script>

{/literal}

</head>

<body>
<h1>設定成績單</h1>
	<table class="datatable">	
<caption>請依照下列步驟完成成績單設定</caption>
	<form method="POST" action="setupCourseGradeReportSave.php">
<!--
	<tr>
		<td><font color="red">1.成績單樣式</font></td>
		<td>
			<select name="templateNumber">
				<option value="1" selected>樣式1</option>
			</select>
			
			<a href="javascript:pop('templateList.php','remoteWindow','width=550,height=400,scrollbars,resizable')">觀看樣式</a>
		</td>
	</tr>
-->

  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------------------------------------------------->

{if $totalGradeNum == 0}
<tr><td colspan="3"><strong>目前無任何成績</strong></td></tr>
{else}
<tr><th colspan="3">請勾選要顯示的項目</th></tr>
  <!------------------------------------------------------------------------------------->
  <!------------------------------------線上測驗------------------------------------------>
  <!------------------------------------------------------------------------------------->

  {if $onlineTestNum > 0}
<tr class="tr2"><td colspan="3">線上測驗</td></tr>
<tr>
  <td style="width:5%;">&nbsp;</td>
  <td colspan="2">
	    {section name=counter loop=$gradeList[1]}
	    <input type="checkbox" name="isPrint_{$gradeList[1][counter].id}" {if $gradeList[1][counter].isPrint==1}checked{/if}/>{$gradeList[1][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_1" {if $isPrintTotoal_1==1}checked{/if}/>線上測驗總分
-->	</td>
  </tr>
  {/if}
  <!------------------------------------------------------------------------------------->
  <!-----------------------------------------線上作業------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $homeworkNum > 0}
  <tr class="tr2"><td colspan="3">線上作業</td></tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2">
	    {section name=counter loop=$gradeList[2]}
	    <input type="checkbox" name="isPrint_{$gradeList[2][counter].id}" {if $gradeList[2][counter].isPrint==1}checked{/if}/>{$gradeList[2][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_2" {if $isPrintTotoal_2==1}checked{/if}/>線上作業總分
-->	</td>
  </tr>
  
  {/if}
  
  <!------------------------------------------------------------------------------------->
  <!-----------------------------------------點名---------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $rollNum > 0}
  <tr class="tr2">    <td colspan="3">點名</td>  </tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2">
	    {section name=counter loop=$gradeList[3]}
	    <input type="checkbox" name="isPrint_{$gradeList[3][counter].id}" {if $gradeList[3][counter].isPrint==1}checked{/if}/>{$gradeList[3][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_3" {if $isPrintTotoal_3==1}checked{/if}/>點名總分
-->	</td>
  </tr>
  
  {/if}
  
  <!------------------------------------------------------------------------------------->
  <!----------------------------------------一般測驗-------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $commTestNum > 0}
  <tr class="tr2">    <td colspan="3">一般測驗</td>  </tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2">
	    {section name=counter loop=$gradeList[4]}
	    <input type="checkbox" name="isPrint_{$gradeList[4][counter].id}" {if $gradeList[4][counter].isPrint==1}checked{/if}/>{$gradeList[4][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_4" {if $isPrintTotoal_4==1}checked{/if}/>一般測驗總分
-->	</td>
  </tr>
  
  {/if}
  
  
  <!------------------------------------------------------------------------------------->
  <!----------------------------------------一般作業-------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $commHomeworkNum > 0}
  <tr class="tr2">    <td colspan="3">一般作業</td>  </tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2">
	    {section name=counter loop=$gradeList[5]}
	    <input type="checkbox" name="isPrint_{$gradeList[5][counter].id}" {if $gradeList[5][counter].isPrint==1}checked{/if}/>{$gradeList[5][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_5" {if $isPrintTotoal_5==1}checked{/if}/>一般作業總分
-->	</td>
  </tr>
  
  {/if}
  
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------其他---------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $otherNum > 0}
  <tr class="tr2">    <td colspan="3">其他</td>  </tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2">
	    {section name=counter loop=$gradeList[9]}
	    <input type="checkbox" name="isPrint_{$gradeList[9][counter].id}" {if $gradeList[9][counter].isPrint==1}checked{/if}/>{$gradeList[9][counter].name}
	    {/section}
  <!--
		<br><input type="checkbox" name="isPrintTotoal_9" {if $isPrintTotoal_9==1}checked{/if}/>其他總分
-->	</td>
  </tr>
  
  {/if}
  
  
  <tr class="tr2">    <td colspan="3">全部</td>  </tr>
  <tr>
    <td style="width:5%;">&nbsp;</td>
	  <td colspan="2"><input type="checkbox" name="isPrintTotoal_99" {if $isPrintTotoal_99==1}checked{/if}/>全部總成績</td>
  </tr>
</table>
{/if}

<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------->		</td>
</tr>
	<tr>
		<td colspan="3"><p class="al-left">
			<input type="reset"  value="清除資料" name="reset" class="btn">

			<input type="submit" value="確定送出" class="btn"> 
			<!--
			<input type="button" value="預覽" onclick="act('sea','one','fa80d6036a976d4a58185fd4f84329a4','true')">
			-->		</p></td>
	</tr>
	</form>
	</table>
</body>
</html>
