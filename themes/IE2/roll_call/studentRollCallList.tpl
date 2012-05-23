<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學生點名列表</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>學生點名列表</h1>
<div class="al-left"><a href="createAllStudentRollCallStateListExcel.php"><img src="{$tpl_path}/images/icon/download.gif" />檔案下載</a></div>
<table class="datatable">
  <tr>
    <th>姓名</th>
    {if $rollCallNum  >0}
    {section name=counter loop=$rollCallList}
    <th>{$rollCallList[counter].name}({$rollCallList[counter].percentage}%)</th>
    {/section}
    {/if}
    
    {if $studentNum  >0}
    {section name=counter loop=$studentList}
  <tr class="{cycle values=",tr2"}">
    <td>{$studentList[counter].name}</td>
    {if $rollCallNum  >0} 
    {section name=counter2 loop=$studentRollCallList[counter]}
    <td> {if $studentRollCallList[counter][counter2]==-1}<img src="{$tpl_path}/images/icon/other.gif" alt="無資料" />{/if}
      {if $studentRollCallList[counter][counter2]==0}<img src="{$tpl_path}/images/icon/attend.gif" alt="出席" />{/if}
      {if $studentRollCallList[counter][counter2]==1}<img src="{$tpl_path}/images/icon/absence.gif" alt="缺席" />{/if}
      {if $studentRollCallList[counter][counter2]==2}<img src="{$tpl_path}/images/icon/late.gif" alt="遲到" />{/if}
      {if $studentRollCallList[counter][counter2]==3}<img src="{$tpl_path}/images/icon/leave.gif" alt="早退" />{/if}
      {if $studentRollCallList[counter][counter2]==4}<img src="{$tpl_path}/images/icon/excuse.gif" alt="請假" />{/if}
      {if $studentRollCallList[counter][counter2]==5}<img src="{$tpl_path}/images/icon/other.gif" alt="其他" />{/if} </td>
    {/section}
    {/if}
    {/section} </tr>
</table>
{/if}
<br />
<p class="intro"><img src="{$tpl_path}/images/icon/attend.gif" />出席。<img src="{$tpl_path}/images/icon/absence.gif" />缺席。<img src="{$tpl_path}/images/icon/late.gif" />遲到。<img src="{$tpl_path}/images/icon/leave.gif" />早退。<img src="{$tpl_path}/images/icon/excuse.gif" />請假。<img src="{$tpl_path}/images/icon/other.gif" />其他（無資料）。
</body>
</html>
