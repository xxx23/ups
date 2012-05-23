<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript" src="{$tpl_path}/script/assignment/delete.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body class="ifr">
<div>
  <form method="GET" action="#" name="ass_del">
    <h1>線上作業</h1>
    <table class="datatable">
      <tbody>
        <tr>
          <th>作業名稱</th>
          <th>繳交期限</th>
          <th>配分</th>
          <th>修改</th>
          <th>解答</th>
	  <th>批閱作業</th>
	  <th>下載作業</th>
	  <th>手動email催繳</th>
	  <th>自動email催繳</th>
          <th>刪除</th>
        </tr>
      {foreach from=$ass_data item=ass}
      <tr class="{cycle values=" ,tr2"}">
        <td><a href="tea_assignment.php?view=true&option=view&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/question.gif" width="13" height="12" border="0"/>{$ass.homework_name}</a></td>
        <td>{$ass.d_dueday}</td>
        <td>{$ass.percentage}</td>
        <td><a href="tea_assignment.php?view=true&option=modify&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/edit.gif" width="24" height="26" border="0"/></a></td>
        <td><a href="tea_answer.php?view=true&homework_no={$ass.homework_no}&option=view"><img src="{$tpl_path}/images/icon/answer.gif" width="13" height="12" border="0"/></a></td>
	<td><a href="tea_correct.php?homework_no={$ass.homework_no}&view=true&option=list_all"><img src="{$tpl_path}/images/icon/correct.gif"/></a></td>
	<td><a href="tea_correct.php?homework_no={$ass.homework_no}&option=download"><img src="{$tpl_path}/images/icon/download.gif" border="0"/></a></td>
	<td><a href="assignment_reminder.php?homework_no={$ass.homework_no}" onclick="return confirm('您確定要立刻催繳作業嗎？\n\n按確定後會立刻催繳一次\n')">立即催繳</a></td>

{if $ass.homework_no|in_array:$remind_homework}
	<td><a href="tea_view.php?homework_no={$ass.homework_no}&remind=0">停用催繳</a></td> 
{else}
	<td><a href="tea_view.php?homework_no={$ass.homework_no}&remind=1">啟用催繳</a></td> 
{/if}
        <td><img src="{$tpl_path}/images/icon/delete.gif" width="24" height="26" border="0" onClick="return delete_work({$ass.homework_no})" style="cursor:pointer;"/></td>
      </tr>
      {foreachelse}
      <tr><td colspan="8" style="text-align:center;">目前無資料</td></tr>
      {/foreach}
      </tbody>
</table>
  </form>
  <h1>合作學習</h1>
  <table class="datatable">
    <tbody>
      <tr>
        <th>作業名稱</th>
        <th>繳交期限</th>
        <th>分組期限</th>
        <th>配分</th>
        <th>題目</th>
        <th>修改</th>
	<th>下載作業</th>
        <th>刪除</th>
      </tr>
    {foreach from=$coll_data item=col}
    <tr class="{cycle values=" ,tr2"}">
      <td>{$col.homework_name}</td>
      <td>{$col.d_dueday}</td>
      <td>{$col.due_date}</td>
      <td>{$col.percentage}</td>
      <td><a href="../Collaborative_Learning/student/question_view.php?homework_no={$col.homework_no}&key={$col.key}"><img src="{$tpl_path}/images/icon/question.gif" width="13" height="12" border="0"/></a></td>
      <td><a href="tea_assignment.php?view=true&option=modify&homework_no={$col.homework_no}"><img src="{$tpl_path}/images/icon/edit.gif" width="24" height="26" border="0"/></a></td>
      <td><a href="tea_correct.php?homework_no={$col.homework_no}&option=download"><img src="{$tpl_path}/images/icon/download.gif" border="0"/></a></td>
      <td><img src="{$tpl_path}/images/icon/delete.gif" width="24" height="26" border="0" style="cursor:pointer;" onClick="return delete_work({$col.homework_no});"/></td>
    </tr>
    {foreachelse}
    <tr><td colspan="8" style="text-align:center;">目前無資料</td></tr>
    {/foreach}
    </tbody>
</table>
</div>
</body>
</html>
