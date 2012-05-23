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
<h1>觀看成績</h1>
{if $totalGradeNum == 0}
<p class="imp">目前無任何成績</p>
{else}
<table class="datatable">
  <tr>
    <th>名稱</th>
    <th>所佔百分比</th>
    <th>狀態</th>
    {if $isModifyOn == 1}
    <th>修改</th>
    {/if}
    {if $isDeleteOn == 1}
    <th>刪除</th>
    {/if} </tr>
  <!------------------------------------------------------------------------------------->
  <!------------------------------------線上測驗------------------------------------------>
  <!------------------------------------------------------------------------------------->
  {if $onlineTestNum > 0}
  <tr class="tr2">
    <td>線上測驗</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[1]}
  <tr>
    <td>{$gradeList[1][counter].name}</td>
    <td>{$gradeList[1][counter].percentage}%</td>
    <td>{if $gradeList[1][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[1][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[1][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
  <!------------------------------------------------------------------------------------->
  <!-----------------------------------------線上作業------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $homeworkNum > 0}
  <tr class="tr2">
    <td>線上作業</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[2]}
  <tr>
    <td>{$gradeList[2][counter].name}</td>
    <td>{$gradeList[2][counter].percentage}%</td>
    <td>{if $gradeList[2][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[2][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[2][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
  <!------------------------------------------------------------------------------------->
  <!-----------------------------------------點名---------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $rollNum > 0}
  <tr class="tr2">
    <td>點名</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[3]}
  <tr>
    <td>{$gradeList[3][counter].name}</td>
    <td>{$gradeList[3][counter].percentage}%</td>
    <td>{if $gradeList[3][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[3][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[3][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
  <!------------------------------------------------------------------------------------->
  <!----------------------------------------一般測驗-------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $commTestNum > 0}
  <tr class="tr2">
    <td>一般測驗</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[4]}
  <tr>
    <td>{$gradeList[4][counter].name}</td>
    <td>{$gradeList[4][counter].percentage}%</td>
    <td>{if $gradeList[4][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[4][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[4][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
  <!------------------------------------------------------------------------------------->
  <!----------------------------------------一般作業-------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $commHomeworkNum > 0}
  <tr class="tr2">
    <td>一般作業</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[5]}
  <tr>
    <td>{$gradeList[5][counter].name}</td>
    <td>{$gradeList[5][counter].percentage}%</td>
    <td>{if $gradeList[5][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[5][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[5][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
  <!------------------------------------------------------------------------------------->
  <!------------------------------------------其他---------------------------------------->
  <!------------------------------------------------------------------------------------->
  {if $otherNum > 0}
  <tr class="tr2">
    <td>其他</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $isModifyOn == 1}
    <td>&nbsp;</td>
    {/if}
    {if $isDeleteOn == 1}
    <td>&nbsp;</td>
    {/if} </tr>
  {section name=counter loop=$gradeList[9]}
  <tr>
    <td>{$gradeList[9][counter].name}</td>
    <td>{$gradeList[9][counter].percentage}%</td>
    <td>{if $gradeList[9][counter].percentage>0}<img src="{$tpl_path}/images/icon/count.gif" />{else}<img src="{$tpl_path}/images/icon/count_x.gif" />{/if}</td>
    {if $isModifyOn == 1}
	<td><a href="modifyGrade.php?id={$gradeList[9][counter].id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteGrade.php?id={$gradeList[9][counter].id}" onClick="return confirm('確定要刪除此成績以及相關資料嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>
    {/if} </tr>
  {/section}
  
  {/if}
</table>
{/if}
</body>
</html>
