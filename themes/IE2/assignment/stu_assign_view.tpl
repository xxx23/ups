<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>線上作業</h1>
<table class="datatable">
  <tbody>
    <tr>
      <th>作業名稱</th>
      <th>繳交期限</th>
      <th>配分</th>
      <th>繳交作業</th>
      <th>觀看已繳交作業</th>
      <th>正確解答</th>
      <th>評語</th>
      <th>優良作業</th>
    </tr>
  {foreach from=$ass_data item=ass}
  <tr class="{cycle values=" ,tr2"}">
    <td><a href="stu_assignment.php?view=true&option=view_quest&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/question.gif" /> {$ass.homework_name}</a></td>
    <td>{$ass.d_dueday|truncate:11:"":true}</td>
    <td>{$ass.percentage}</td>
    <td><input type="button" class="btn" value="繳交作業" onClick="location.href='stu_assignment.php?view=true&option=update&homework_no={$ass.homework_no}'" {$ass.disabled}/></td>
    <td><a href="stu_assignment.php?view=true&option=view_ans&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/view.gif" /></a></td>
    <td>
    {if $ass.pubAns == 1}
    <a href="stu_assignment.php?view=true&option=ans&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/answer.gif" /></a>
    {/if}
    </td>
    <td><a href="stu_assignment.php?view=true&option=comment&homework_no={$ass.homework_no}"><img src="{$tpl_path}/images/icon/comment.gif" /></a></td>
    <td><a href="stu_excellent.php?option=list_all&homework_no={$ass.homework_no}" target="_self"><img src="{$tpl_path}/images/icon/pass.gif" width="24" height="26" /></a></td>
  </tr>
  {/foreach}
  </tbody>
</table>
<h1>
  合作學習
</h1>
<table class="datatable">
      <tbody>
      <tr>
	<th>作業名稱</th>
	<th>繳交期限</th>
	<th>分組期限</th>
	<th>配分</th>
	<!--<th>繳交作業</th>-->
	<th>題目</th>
      </tr>
      {foreach from=$co_data item=ass}
      <tr class="{cycle values=" ,tr2"}">
	<td><a href="../Collaborative_Learning/student/stu_co_learn.php?homework_no={$ass.homework_no}&key={$ass.key}">{$ass.homework_name}</a></td>
	<td>{$ass.d_dueday}</td>
	<td>{$ass.due_date}</td>
	<td>{$ass.percentage} %</td>
	<!--<td><input type="button" class="btn" value="繳交作業" onClick="location.href='stu_assignment.php?view=true&option=update&homework_no={$ass.homework_no}'" {$ass.disabled}/></td>-->
	<td><a href="../Collaborative_Learning/student/question_view.php?homework_no={$ass.homework_no}&key={$ass.key}"><img src="{$tpl_path}/images/icon/question.gif"></a></td>
      </tr>
      {/foreach}
      </tbody>
    </table>
</body>
</html>
