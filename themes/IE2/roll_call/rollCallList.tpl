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
<h1>點名列表</h1>
{if $rollNum == 0}
<p class="imp">目前無任何點名</p>
{else}


<table class="datatable">
  <tr>
    <th>名稱</th>
    <th>所佔百分比</th>
    <th>日期</th>
    <th>狀態</th>
    {if $isShowUnusualListLink == 1}
    <th>異常名單</th>
    {/if}
    {if $isModifyOn == 1}
    <th>修改</th>
    {/if}
    {if $isDeleteOn == 1}
    <th>刪除</th>
    {/if} </tr>
  <!------------------------------------------------------------------------------------->
  <!-----------------------------------------點名---------------------------------------->
  <!------------------------------------------------------------------------------------->
  {section name=counter loop=$rollCallList}
  <tr>
    <td>{$rollCallList[counter].name}</td>
    <td>{$rollCallList[counter].percentage}%</td>
    <td>{$rollCallList[counter].roll_date}</td>
    <td>{if $rollCallList[counter].percentage>0}<span class="imp">記分</span>{else}不計分{/if}</td>
    {if $isShowUnusualListLink == 1}
    <td><form method="post" action="showOneRollCallStudentUnusualStateList.php">
      <input type="hidden" name="roll_id" value="{$rollCallList[counter].roll_id}">
      <input type="hidden" name="currentPage" value="{$currentPage}">
      <input type="submit" name="submit" value="觀看異常名單" class="btn"></form>
      </td>
    
    {/if}
    {if $isModifyOn == 1}
    <td><a href="modifyRollCall.php?roll_id={$rollCallList[counter].roll_id}&currentPage={$currentPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>   
    {/if}
    {if $isDeleteOn == 1}
    <td><a href="deleteRollCall.php?roll_id={$rollCallList[counter].roll_id}" onClick="return confirm('確定要刪除這項點名以及學員的成績?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>  
    {/if} </tr>
  {/section}
</table>
{/if}
</div>
</body>
</html>
